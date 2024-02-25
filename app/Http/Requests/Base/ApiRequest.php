<?php
namespace App\Http\Requests\Base;





use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class ApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    abstract  public function authorize();

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    abstract  public function rules();


    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        if (!empty($errors)) {
            $transFormedErrors = [];
            foreach ($errors as $filed => $message) {
                $transFormedErrors[] = [
                    $filed => $message[0]
                ];
            }

            throw new HttpResponseException(
                response()->json(
                    [
                        'status' => 'error',
                        'errors' => $transFormedErrors
                    ],
                    JsonResponse::HTTP_BAD_REQUEST
                )
            );
        }
    }
}
