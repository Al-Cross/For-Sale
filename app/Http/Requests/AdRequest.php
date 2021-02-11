<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'city' => ['required', 'exists:cities'],
            'title' => ['required', 'string'],
            'description' => ['required', 'min:10'],
            'price' => ['required', 'numeric'],
            'type' => ['required', 'string', 'in:private,business'],
            'condition' => ['required', 'string', 'in:new,used'],
            'delivery' => ['required', 'string', 'in:seller,buyer,personal handover'],
            'image' => 'array',
            'image.*' => ['image', 'mimes:jpeg,jpg,png']
        ];

        return $rulesForCreate = $this->postMergeRule($rules, 'section_id', 'required');
    }

    public function messages()
    {
        return [
            'city.exists' => 'We do not operate in the selected city.'
        ];
    }

    /**
     * If the method of the request is a POST,
     * then return the rules with additional rule
     *
     * @param array  $rules     Array of rules determined so far
     * @param string $attribute form element that will have rules applied
     * @param string $rule      the actual rule
     *
     * @return array            the array with the rule added, else the original
     */
    public function postMergeRule($rules, $attribute, $rule = [])
    {
        if ($this->method() == 'POST') {
            $rules = array_merge($rules, [$attribute => $rule]);
        }

        return $rules;
    }

}
