<x-app-layout>
   <x-slot name="header">
      <h1 class="m-0 section-title">Perfil</h1>
   </x-slot>

   <div class="stack-gap profile-container">
      <x-ui.card>
         @include('profile.partials.update-profile-information-form')
      </x-ui.card>

      <x-ui.card>
         @include('profile.partials.update-password-form')
      </x-ui.card>

      <x-ui.card>
         @include('profile.partials.delete-user-form')
      </x-ui.card>
   </div>
</x-app-layout>
