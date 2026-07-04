<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

final class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category' => ['required', 'string', 'max:80'],
            'priority' => ['required', 'in:low,normal,high,urgent'],
            'subject'  => ['required', 'string', 'max:150'],
            'body'     => ['required', 'string', 'max:10000'],
        ];
    }
}
