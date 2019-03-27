<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Compliance\Validation\Errors\ValidationError;
use Compliance\Validation\Errors\ValidationErrorBag;
use Compliance\Validation\Rules\NullDataRule;
use Compliance\Validation\Rules\WhitespaceRule;
use Compliance\Validation\RuleGroups\NonNullRuleGroup;
use Compliance\Validation\Validators\Validator;
use Compliance\Validation\Validators\SubjectValidator;
use Compliance\Sanitization\Routines\RemoveSlashesRoutine;
use Compliance\Sanitization\Routines\StripTagsRoutine;
use Compliance\Sanitization\Routines\TrimRoutine;
use Compliance\Sanitization\RoutineGroups\SanitizeHTMLRoutineGroup;
use Compliance\Sanitization\Sanitizers\Sanitizer;
use App\Tag;

class ComplianceValidationTest extends TestCase
{
    /**
     * Test the ValidationError
     *
     * @return void
     */
    public function testValidationError()
    {
        // Environment
        $error = new ValidationError();
        $error->field = 'Field';
        $error->message = 'Message';
        $error->rule = 'Rule';
        $error->subject = 'Subject';
        $error->suggestions = ['Suggestion'];
        $error->value = 'Value';

        $standardArray = ['Field', 'Message', 'Rule', 'Subject', ['Suggestion'], 'Value'];

        // Act
        $errorArray = [$error->field, $error->message, $error->rule, $error->subject, $error->suggestions, $error->value];

        // Assert
        $this->assertEquals($standardArray, $errorArray);
    }

    /**
     * Test the ValidationErrorBag with no errors
     */
    public function testValidationErrorBagSingle()
    {
        // Environment
        $bag = new ValidationErrorBag();

        // Act

        // Assert
        $this->assertTrue($bag->count() == 0);
    }

    /**
     * Test the ValidationErrorBag with an array of errors
     */
    public function testValidationErrorBagArray()
    {
        $bag = new ValidationErrorBag(['a', 'b', 'c']);

        $this->assertTrue($bag->count() == 3);
        $this->assertTrue($bag->all()[0] == 'a');
        $this->assertTrue($bag->all()[1] == 'b');
        $this->assertTrue($bag->all()[2] == 'c');
    }

    /**
     * NullDataRule test - null data
     */
    public function testNullDataNull()
    {
        // Environment
        $subject = null;
        $rule = new NullDataRule($subject);

        // Act
        $isValid = $rule->validate();

        // Assert
        $this->assertFalse($isValid);
    }

    /**
     * NullDataRule test - non null data
     */
    public function testNullDataNonNull()
    {
        // Environment
        $subject = "I am some non null data";
        $rule = new NullDataRule($subject);

        // Act
        $isValid = $rule->validate();

        // Assert
        $this->assertTrue($isValid);
    }

    /**
     * Test the NonNullRuleGroup
     */
    public function testNonNullRuleGroup()
    {
        $ruleGroup = new NonNullRuleGroup();

        $f = new \ReflectionClass($ruleGroup->getRules()['NullDataRule']);
        $b = new \ReflectionClass($ruleGroup->getRules()['WhitespaceRule']);

        $this->assertTrue($f->getShortName() == 'NullDataRule');
        $this->assertTrue($b->getShortName() == 'WhitespaceRule');
    }

    /**
     * Test the base Validator
     */
    public function testBaseValidator()
    {
        // Environment
        $subject = null;
        $nonNullRule = new NullDataRule();
        $whitespaceRule = new WhitespaceRule();
        $ruleGroup = new NonNullRuleGroup();
        $validator = new Validator();
        $isValidRules = true;
        $isValidRuleGroup = false;

        // Act
        // Rules
        $nonNullRule->setSubject($subject);
        $whitespaceRule->setSubject($subject);
        $validator->setRules([$nonNullRule, $whitespaceRule]);
        $isValidRules = $validator->validate();

        // RuleGroup
        foreach($ruleGroup->getRules() as $rule)
        {
            $rule->setSubject($subject);
        }
        $validator->setRules($ruleGroup);
        $isValidRuleGroup = $validator->validate();

        // Assert
        $this->assertFalse($isValidRules);
        $this->assertFalse($isValidRuleGroup);
    }

    /**
     * Test the SubjectValidator
     */
    public function testSubjectValidator()
    {
        // Environment
        $subject = " I have whitespace  ";
        $nonNullRule = new NullDataRule();
        $whitespaceRule = new WhitespaceRule();
        $ruleGroup = new NonNullRuleGroup();
        $validator = new SubjectValidator($subject);
        $isValidRules = false;
        $isValidRuleGroup = false;

        // Act
        // Rules
        $validator->setRules([$nonNullRule, $whitespaceRule]);
        $isValidRules = $validator->validate();

        // RuleGroup
        $validator->setRules($ruleGroup);
        $isValidRuleGroup = $validator->validate();

        // Assert
        $this->assertFalse($isValidRules);
        $this->assertFalse($isValidRuleGroup);
    }

    /**
     * Test the Routines
     */
    public function testRoutines()
    {
        // Environment
        $removeSlashesBefore = "/no slash\\es";
        $stripTagsBefore = "<script>alert('gotcha loser!');</script>";
        $removeSlashesAfter = "no slashes";
        $stripTagsAfter = "alert('gotcha loser!');";
        $removeSlashesRoutine = RemoveSlashesRoutine::class;
        $stripTagsRoutine = StripTagsRoutine::class;

        // Act

        // Assert
        $this->assertEquals(RemoveSlashesRoutine::sanitize($removeSlashesBefore), $removeSlashesAfter);
        $this->assertEquals(StripTagsRoutine::sanitize($stripTagsBefore), $stripTagsAfter);
    }

    /**
     * Test the RoutineGroups
     */
    public function testRoutineGroups()
    {
        // Environment
        $before = "<div class='className'>Here is a slash free string! / / / \ \ \</div>";
        $after = "Here is a slash free string!";

        // Act

        // Assert
        $this->assertEquals(Sanitizer::sanitize($before, new SanitizeHTMLRoutineGroup()), $after);
    }

    /**
     * Test the Eloquent sanitization trait using the Tag model
     */
    public function testTagModelSanitization()
    {
        // Environment
        $tag = new Tag;
        $tag->key = " <div>Key</div>  ";
        $tag->value = "//Value  <p></p>";
        $tag->display_key = "  Display \/Key";
        $tag->display_value = "<p><a>Value</a></p><br>  ";

        // Act
        $tag->sanitize();

        // Assert
        $this->assertEquals($tag->key, 'Key');
        $this->assertEquals($tag->value, 'Value');
        $this->assertEquals($tag->display_key, 'Display Key');
        $this->assertEquals($tag->display_value, 'Value');
    }

    /**
     * Test the Eloquent validation trait using the Tag model
     */
    public function testTagModelValidation()
    {
        // Environment
        $tag = new Tag;
        $tag->key = " Key";
        $tag->value = "  Value  ";
        $tag->display_key = "   Display Key ";
        $tag->display_value = "     Display Value    ";

        // Act
        $isValid = $tag->validate();

        // Assert
        $this->assertFalse($isValid);
        $this->assertEquals($tag->getErrors()->count(), 4);
    }
}
