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

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Name Field -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email Field -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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

        <!-- Phone Field -->
        <div>
            <x-input-label for="phone" :value="__('Phone Number')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" autocomplete="tel" placeholder="Contoh: +62812345678" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <!-- Location Field -->
        <div>
            <x-input-label for="location" :value="__('Location')" />
            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location', $user->location)" autocomplete="address-level1" placeholder="Contoh: Jakarta, Indonesia" />
            <x-input-error class="mt-2" :messages="$errors->get('location')" />
        </div>

        <!-- Bio Field -->
        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <textarea id="bio" name="bio" rows="4"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Ceritakan sedikit tentang diri Anda..."
                maxlength="500">{{ old('bio', $user->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
            <p class="mt-1 text-sm text-gray-500">Maksimal 500 karakter</p>
        </div>

        <!-- Skills Field (Optional - sebagai tags) -->
        <div>
            <x-input-label for="skills" :value="__('Skills')" />
            <div id="skills-container" class="mt-1">
                <div class="flex flex-wrap gap-2 mb-2" id="skills-list">
                    @if($user->skills && is_array($user->skills))
                        @foreach($user->skills as $skill)
                            <span
                                class="skill-tag inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                                {{ $skill }}
                                <button type="button" class="ml-1 text-blue-600 hover:text-blue-800"
                                    onclick="removeSkill(this)">×</button>
                            </span>
                        @endforeach
                    @endif
                </div>
                <div class="flex">
                    <x-text-input id="skill-input" type="text" class="flex-1"
                        placeholder="Tambahkan skill (tekan Enter)" onkeypress="addSkill(event)" />
                </div>
                <!-- Hidden inputs untuk skills -->
                <div id="skills-inputs">
                    @if($user->skills && is_array($user->skills))
                        @foreach($user->skills as $index => $skill)
                            <input type="hidden" name="skills[{{ $index }}]" value="{{ $skill }}">
                        @endforeach
                    @endif
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('skills')" />
            <p class="mt-1 text-sm text-gray-500">Tekan Enter untuk menambahkan skill</p>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    <!-- JavaScript for Skills Management -->
    <script>
        let skillIndex = {{ $user->skills ? count($user->skills) : 0 }};

        function addSkill(event) {
            if (event.key === 'Enter') {
                event.preventDefault();

                const input = document.getElementById('skill-input');
                const skill = input.value.trim();

                if (skill && skill.length > 0) {
                    // Create skill tag
                    const skillTag = document.createElement('span');
                    skillTag.className = 'skill-tag inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800';
                    skillTag.innerHTML = `
                        ${skill}
                        <button type="button" class="ml-1 text-blue-600 hover:text-blue-800" onclick="removeSkill(this)">×</button>
                    `;

                    // Add to skills list
                    document.getElementById('skills-list').appendChild(skillTag);

                    // Create hidden input
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = `skills[${skillIndex}]`;
                    hiddenInput.value = skill;
                    hiddenInput.setAttribute('data-skill', skill);

                    document.getElementById('skills-inputs').appendChild(hiddenInput);

                    // Clear input and increment index
                    input.value = '';
                    skillIndex++;
                }
            }
        }

        function removeSkill(button) {
            const skillTag = button.parentElement;
            const skillValue = skillTag.textContent.replace('×', '').trim();

            // Remove skill tag
            skillTag.remove();

            // Remove corresponding hidden input
            const hiddenInput = document.querySelector(`input[data-skill="${skillValue}"]`);
            if (hiddenInput) {
                hiddenInput.remove();
            }

            // Reindex remaining inputs
            reindexSkills();
        }

        function reindexSkills() {
            const inputs = document.querySelectorAll('#skills-inputs input[type="hidden"]');
            inputs.forEach((input, index) => {
                input.name = `skills[${index}]`;
            });
            skillIndex = inputs.length;
        }
    </script>
</section>