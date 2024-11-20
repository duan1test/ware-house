<x-guest-layout>
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif
        <style>
            .form-control:focus + .input-group-text {
                transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
                border: 1px solid #7f4dd6;
            }
        </style>
        <div class="wrapper">
            <div class="section-authentication-login d-flex align-items-center justify-content-center mt-4">
                <div class="row">
                    <div class="col-12 col-lg-8 mx-auto">
                        <div class="card radius-15 overflow-hidden">
                            <div class="row g-0">
                                <div class="col-xl-6 d-flex justify-content-center align-items-center">
                                    <div class="card-body p-5">
                                        <div class="text-center">
                                            <img src="assets/images/logo-icon.png" width="80" alt="">
                                        </div>
                                        <div class="">
                                            <div class="form-body">
                                                <x-validation-errors class="mb-4 text-danger mt-4" />
                                                <form class="row g-3" method="POST" action="{{ route('login') }}">
                                                    @csrf
                                                    <div class="col-12">
                                                        <x-label for="user_name" value="{{ __('common.auth.user_name') }}" />
                                                        <x-input id="email" class="block mt-1 w-full form-control" placeholder="{{ __('common.auth.user_name') }}" type="text" name="username" :value="old('email')" required oninvalid="this.setCustomValidity('{{ __('common.auth.user_name_required') }}')"  oninput="this.setCustomValidity('')" autofocus autocomplete="username" />
                                                    </div>
                                                    <div class="col-12">
                                                        <x-label for="password" value="{{ __('attributes.user.password') }}" />
                                                        <div class="input-group" id="show_hide_password">
                                                            <x-input id="password" class="form-control border-end-0" type="password" name="password" required required oninvalid="this.setCustomValidity('{{ __('common.auth.password_required') }}')"  oninput="this.setCustomValidity('')" autocomplete="current-password" placeholder="{{ __('attributes.user.password') }}" />
                                                            <a href="javascript:;" class="input-group-text bg-transparent">
                                                                <i class="bx bx-hide"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-check form-switch">
                                                            <x-checkbox class="form-check-input" type="checkbox" id="remember_me" checked="" name="remember" />
                                                            <label class="form-check-label" for="flexSwitchCheckChecked">{{ __('common.auth.remember') }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="d-grid">
                                                            <button type="submit" class="btn btn-primary"><i class="bx bxs-lock-open"></i>{{ __('common.auth.login') }}</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 bg-login-color d-flex align-items-center justify-content-center">
                                    <img src="assets/images/login-images/login-frent-img.jpg" class="img-fluid" alt="...">
                                </div>
                            </div>
                            <!--end row-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-guest-layout>
