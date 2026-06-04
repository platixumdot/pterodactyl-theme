@extends('pltx-theme::layouts.app')

@section('page-title', 'Billing')

@section('content')
    <section class="page-header">
        <h2>Billing-System</h2>
        <p>Guthaben, Rechnungen, Transaktionsverlauf und Gutscheincodes.</p>
    </section>

    <section class="card-grid">
        @foreach($accounts as $account)
            <article class="glass-card">
                <span class="card-kicker">Account</span>
                <h3>{{ $account->currency }} {{ number_format((float) $account->balance, 2, ',', '.') }}</h3>
                <p>User #{{ $account->user_id ?? 'guest' }}</p>
            </article>
        @endforeach
    </section>

    <section class="card-grid">
        @foreach($transactions as $transaction)
            <article class="glass-card">
                <span class="card-kicker">Transaktion</span>
                <h3>{{ $transaction->type }}</h3>
                <p>{{ $transaction->provider ?? 'system' }} · {{ number_format((float) $transaction->amount, 2, ',', '.') }}</p>
            </article>
        @endforeach
    </section>
@endsection
