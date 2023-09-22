@component('mail::message')
<!-- {{-- Greeting --}}
@if (! empty($greeting))
# 
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
@endif
@endif -->
<p>Bonjour!</p>

<!-- {{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach -->
<p>Vous recevez cet e-mail car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte</p>

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
<!-- {{ $actionText }} --> Réinitialiser le mot de passe
@endcomponent
@endisset

<!-- {{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach -->
<p>Ce lien de réinitialisation de mot de passe expirera dans 60 minutes.</p>

<!-- {{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else -->
<p>Si vous n'avez pas demandé de réinitialisation de mot de passe, aucune action supplémentaire n'est nécessaire.
<br>Salutations,<br>
{{ config('app.name') }}
@endif
</p>
{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "Si vous rencontrez des difficultés à cliquer sur le bouton 'Réinitialiser le mot de passe', copiez et collez l'URL ci-dessous\n".
    'dans votre navigateur web : [:actionURL](:actionURL)',
    [
        'actionURL' => $actionUrl,
    ]
)
@endslot
@endisset
@endcomponent
