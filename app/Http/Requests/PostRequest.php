<?php

namespace App\Http\Requests;

use App\Helpers\ResponseHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $data = [
            'content' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',

            'videos' => 'nullable|array',
            'videos.*' => 'mimetypes:video/avi,video/mp4,video/mpeg,video/quicktime|max:10240',
        ];


        if ($this->method() == 'PUT') {
            $data['images.*'] = [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (is_string($value)) {
                        return true;
                    }
                    if (!is_file($value) || !$value->isValid() || !in_array($value->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'])) {
                        $fail('The ' . $attribute . ' must be a valid image or a string.');
                    }
                },
            ];

            $data['videos.*'] = [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (is_string($value)) {
                        return true;
                    }
                    if (!is_file($value) || !$value->isValid() || !in_array($value->getMimeType(), ['video/avi', 'video/mp4', 'video/mpeg', 'video/quicktime'])) {
                        $fail('The ' . $attribute . ' must be a valid video or a string.');
                    }
                    if ($value->getSize() > 10240 * 1024) {
                        $fail('The ' . $attribute . ' must not exceed 10MB.');
                    }
                },
            ];
        }

        return $data;
    }


    // public function messages(): array
    // {
    //     return [
    //         [
    //             'images.*.image' => 'File ảnh không hợp lệ.',
    //             'images.*.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif.',
    //             'images.*.max' => 'Dung lượng ảnh không được vượt quá 2MB.',
    //             'videos.*.mimetypes' => 'Video phải có định dạng: avi, mp4, mpeg, hoặc quicktime.',
    //             'videos.*.max' => 'Dung lượng video không được vượt quá 10MB.',
    //         ]
    //     ];
    // }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw (new ValidationException($validator, ResponseHelper::error('Validation error', $errors->toArray(), 422)))
            ->status(422);
    }
}
