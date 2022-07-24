<?php

namespace Domain\UseCases\Inputs;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidatesWhenResolvedTrait;

abstract class ValidatesInput implements ValidatesWhenResolved, InputInterface
{
    use ValidatesWhenResolvedTrait;

    protected ?Validator $validator = null;

    /**
     * @var array
     */
    protected array $inputs;

    abstract protected function rules(): array;

    /**
     * @param array $inputs
     * @throw ValidationException
     */
    final public function __construct(array $inputs)
    {
        $this->inputs = $inputs;
        $this->getValidatorInstance();
        $this->validateResolved();
    }

    public function toArray()
    {
        return $this->inputs;
    }

    /**
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request)
    {
        return new static($request->all());
    }

    private function getValidatorInstance(): Validator
    {
        if ($this->validator) {
            return $this->validator;
        }

        $factory = app('validator');

        $validator = $this->createValidator($factory);
        if (method_exists($this, 'withValidator')) {
            $this->withValidator($validator);
        }

        $this->validator = $validator;

        return $this->validator;
    }

    public function messages(): array
    {
        return [];
    }

    public function attributes(): array
    {
        return [];
    }

    private function createValidator(ValidationFactory $factory): Validator
    {
        return $factory->make(
            $this->inputs,
            $this->rules(),
            $this->messages(),
            $this->attributes()
        );
    }
}
