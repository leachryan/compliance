<?php 

namespace Compliance\Validation\Rules;

use Compliance\Validation\Errors\ValidationError;
use Compliance\Validation\Errors\ValidationErrorBag;
use DB;

class ContentAttributeAssignmentRule extends AbstractRule
{
    /**
     * The check to be performed on the subject.
     * 
     * @return bool $isValid
     */
    public function validate() : bool
    {
        // Need to test that both the content asset, content attribute, and content attribute value are all valid
        $valid = true;

        // Content Asset
        $contentAsset = DB::table('contentAssets')->where('id', $this->subject->content_asset_id)->first();
        $valid = $contentAsset ? $valid : false;

        // Content Attribute
        $contentAttribute = DB::table('contentAttributes')->where('id', $this->subject->content_attribute_id)->first();
        $valid = $contentAttribute ? $valid : false;

        // Content Attribute Value
        $contentAttributeValue = DB::table('contentAttributeValues')->where('id', $this->subject->content_attribute_value_id)->first();
        $valid = $contentAttributeValue ? $valid : false;

        return $valid;
    }
}