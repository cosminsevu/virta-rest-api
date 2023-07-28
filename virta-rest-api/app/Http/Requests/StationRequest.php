<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema()
 */
class StationRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'company_id' => 'required|exists:companies,id',
            'address' => 'required|string',
        ];
    }

    /**
     * Get the JSON representation of the request body schema.
     *
     * @return string
     */
    public function requestBodySchema()
    {
        $rules = $this->rules();

        $properties = [];
        foreach ($rules as $field => $fieldRules) {
            $type = $this->getRuleType($fieldRules);
            $properties[$field] = ['type' => $type];
        }

        return json_encode([
            'type' => 'object',
            'properties' => $properties,
        ]);
    }

    // Helper method to determine the data type for the @OA\Property annotation
    private function getRuleType($rule)
    {
        if (strpos($rule, 'numeric') !== false || strpos($rule, 'integer') !== false) {
            return 'number';
        } elseif (strpos($rule, 'string') !== false) {
            return 'string';
        } elseif (strpos($rule, 'boolean') !== false) {
            return 'boolean';
        }

        return 'string'; // Default to string if the data type cannot be determined
    }


}
