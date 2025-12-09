<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- PENTING: enctype untuk upload foto --}}
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- FOTO PROFIL --}}
        <div>
            <x-input-label for="profile_photo" :value="__('Foto Profil')" />

            <div class="flex items-center gap-4 mt-2">
                @if (!empty($user->profile_photo))
                    <img
                        src="{{ asset('storage/profile/' . $user->profile_photo) }}"
                        alt="Profile Photo"
                        class="w-20 h-20 rounded-full object-cover border"
                    />
                @else
                    <img
                        src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4F46E5&color=fff"
                        alt="Default Avatar"
                        class="w-20 h-20 rounded-full object-cover border"
                    />
                @endif

                <div>
                    <input
                        type="file"
                        id="profile_photo"
                        name="profile_photo"
                        accept="image/*"
                        class="block w-full text-sm text-gray-700"
                    />

                    <p class="text-xs text-gray-500 mt-1">
                        Format yang diizinkan: JPG, JPEG, PNG, WEBP — Max 2MB
                    </p>

                    <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
                </div>
            </div>
        </div>

        {{-- Name --}}
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
            />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
            />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button
                            form="send-verification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Phone Number + Country Code --}}
        <div>
            <x-input-label for="phone" :value="__('Phone Number')" />

            <div class="mt-1 flex gap-2">
                {{-- Kode Negara + Bendera --}}
                <select
                    id="phone_country"
                    name="phone_country"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md w-32 overflow-y-auto"
                >
                    {{-- Indonesia default --}}
                    <option value="+62" @selected(old('phone_country', $user->phone_country ?? '+62') == '+62')>🇮🇩 +62</option>

                    <option value="+60" @selected(old('phone_country', $user->phone_country ?? '') == '+60')>🇲🇾 +60</option>
                    <option value="+65" @selected(old('phone_country', $user->phone_country ?? '') == '+65')>🇸🇬 +65</option>
                    <option value="+66" @selected(old('phone_country', $user->phone_country ?? '') == '+66')>🇹🇭 +66</option>
                    <option value="+81" @selected(old('phone_country', $user->phone_country ?? '') == '+81')>🇯🇵 +81</option>
                    <option value="+82" @selected(old('phone_country', $user->phone_country ?? '') == '+82')>🇰🇷 +82</option>
                    <option value="+91" @selected(old('phone_country', $user->phone_country ?? '') == '+91')>🇮🇳 +91</option>
                    <option value="+1"  @selected(old('phone_country', $user->phone_country ?? '') == '+1')>🇺🇸 +1</option>
                    <option value="+44" @selected(old('phone_country', $user->phone_country ?? '') == '+44')>🇬🇧 +44</option>
                </select>

                {{-- Nomor HP --}}
                <x-text-input
                    id="phone"
                    name="phone"
                    type="text"
                    class="block w-full"
                    :value="old('phone', $user->phone ?? '')"
                    placeholder="81234567890"
                    autocomplete="tel"
                />
            </div>

            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            <x-input-error class="mt-2" :messages="$errors->get('phone_country')" />
        </div>

        {{-- Save Button --}}
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
