<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

final class StoreNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'note' => ['required', 'string', 'max:5000'],
        ];
    }
}
