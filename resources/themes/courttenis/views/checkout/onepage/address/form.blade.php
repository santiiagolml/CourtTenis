@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-checkout-address-form-template"
    >
        <div class="mt-2 max-md:mt-3">
            <x-shop::form.control-group class="hidden">
                <x-shop::form.control-group.control
                    type="text"
                    ::name="controlName + '.id'"
                    ::value="address.id"
                />
            </x-shop::form.control-group>

            {{-- Company Name - oculto --}}
            <x-shop::form.control-group class="hidden">
                <x-shop::form.control-group.control
                    type="text"
                    ::name="controlName + '.company_name'"
                    ::value="address.company_name"
                    :placeholder="trans('shop::app.checkout.onepage.address.company-name')"
                />
            </x-shop::form.control-group>

            {!! view_render_event('bagisto.shop.checkout.onepage.address.form.company_name.after') !!}

            <!-- First Name -->
            <div class="grid grid-cols-2 gap-x-5 max-md:grid-cols-1">
                <x-shop::form.control-group>
                    <x-shop::form.control-group.label class="required !mt-0">
                        @lang('shop::app.checkout.onepage.address.first-name')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        ::name="controlName + '.first_name'"
                        ::value="address.first_name"
                        rules="required"
                        :label="trans('shop::app.checkout.onepage.address.first-name')"
                        :placeholder="trans('shop::app.checkout.onepage.address.first-name')"
                    />

                    <x-shop::form.control-group.error ::name="controlName + '.first_name'" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.checkout.onepage.address.form.first_name.after') !!}

                <!-- Last Name -->
                <x-shop::form.control-group>
                    <x-shop::form.control-group.label class="required !mt-0">
                        @lang('shop::app.checkout.onepage.address.last-name')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        ::name="controlName + '.last_name'"
                        ::value="address.last_name"
                        rules="required"
                        :label="trans('shop::app.checkout.onepage.address.last-name')"
                        :placeholder="trans('shop::app.checkout.onepage.address.last-name')"
                    />

                    <x-shop::form.control-group.error ::name="controlName + '.last_name'" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.checkout.onepage.address.form.last_name.after') !!}
            </div>

            <!-- Email -->
            <x-shop::form.control-group>
                <x-shop::form.control-group.label class="required !mt-0">
                    @lang('shop::app.checkout.onepage.address.email')
                </x-shop::form.control-group.label>

                <x-shop::form.control-group.control
                    type="email"
                    ::name="controlName + '.email'"
                    ::value="address.email"
                    rules="required|email"
                    :label="trans('shop::app.checkout.onepage.address.email')"
                    placeholder="email@example.com"
                />

                <x-shop::form.control-group.error ::name="controlName + '.email'" />
            </x-shop::form.control-group>

            {!! view_render_event('bagisto.shop.checkout.onepage.address.form.email.after') !!}

            {{-- VAT ID - oculto --}}
            <template v-if="controlName=='billing'">
                <x-shop::form.control-group class="hidden">
                    <x-shop::form.control-group.control
                        type="text"
                        ::name="controlName + '.vat_id'"
                        ::value="address.vat_id"
                        :label="trans('shop::app.checkout.onepage.address.vat-id')"
                        :placeholder="trans('shop::app.checkout.onepage.address.vat-id')"
                    />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.checkout.onepage.address.form.vat_id.after') !!}
            </template>

            <!-- Street Address -->
            <x-shop::form.control-group>
                <x-shop::form.control-group.label class="required !mt-0">
                    @lang('shop::app.checkout.onepage.address.street-address')
                </x-shop::form.control-group.label>

                <x-shop::form.control-group.control
                    type="text"
                    ::name="controlName + '.address.[0]'"
                    ::value="address.address[0]"
                    rules="required"
                    :label="trans('shop::app.checkout.onepage.address.street-address')"
                    :placeholder="trans('shop::app.checkout.onepage.address.street-address')"
                />

                <x-shop::form.control-group.error
                    class="mb-2"
                    ::name="controlName + '.address.[0]'"
                />

                @if (core()->getConfigData('customer.address.information.street_lines') > 1)
                    @for ($i = 1; $i < core()->getConfigData('customer.address.information.street_lines'); $i++)
                        <x-shop::form.control-group.control
                            type="text"
                            ::name="controlName + '.address.[{{ $i }}]'"
                            rules="address"
                            :label="trans('shop::app.checkout.onepage.address.street-address')"
                            :placeholder="trans('shop::app.checkout.onepage.address.street-address')"
                        />

                        <x-shop::form.control-group.error
                            class="mb-2"
                            ::name="controlName + '.address.[{{ $i }}]'"
                        />
                    @endfor
                @endif
            </x-shop::form.control-group>

            {!! view_render_event('bagisto.shop.checkout.onepage.address.form.address.after') !!}

            {{-- País - oculto --}}
            <div class="hidden">
                <x-shop::form.control-group class="!mb-4">
                    <x-shop::form.control-group.control
                        type="select"
                        ::name="controlName + '.country'"
                        v-model="selectedCountry"
                        rules="{{ core()->isCountryRequired() ? 'required' : '' }}"
                        :label="trans('shop::app.checkout.onepage.address.country')"
                    >
                        <option value="CO">Colombia</option>
                    </x-shop::form.control-group.control>
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.checkout.onepage.address.form.country.after') !!}

                {{-- Estado - oculto con v-model forzado --}}
                <x-shop::form.control-group>
                    <x-shop::form.control-group.control
                        type="select"
                        ::name="controlName + '.state'"
                        v-model="selectedState"
                        :label="trans('shop::app.checkout.onepage.address.state')"
                    >
                        <option value="CO-CUN">Cundinamarca</option>
                        <option value="CO-ANT">Antioquia</option>
                        <option value="CO-VAC">Valle del Cauca</option>
                        <option value="CO-ATL">Atlántico</option>
                        <option value="CO-BOL">Bolívar</option>
                        <option value="CO-SAN">Santander</option>
                        <option value="CO-COR">Córdoba</option>
                        <option value="CO-NAR">Nariño</option>
                        <option value="CO-TOL">Tolima</option>
                        <option value="CO-CAU">Cauca</option>
                        <option value="CO-HUI">Huila</option>
                        <option value="CO-MAG">Magdalena</option>
                        <option value="CO-BOY">Boyacá</option>
                        <option value="CO-CAL">Caldas</option>
                        <option value="CO-RIS">Risaralda</option>
                        <option value="CO-QUI">Quindío</option>
                        <option value="CO-CES">Cesar</option>
                        <option value="CO-MET">Meta</option>
                        <option value="CO-NSA">Norte de Santander</option>
                        <option value="CO-CHO">Chocó</option>
                        <option value="CO-LAG">La Guajira</option>
                        <option value="CO-SUC">Sucre</option>
                        <option value="CO-PUT">Putumayo</option>
                        <option value="CO-CAS">Casanare</option>
                        <option value="CO-ARA">Arauca</option>
                        <option value="CO-AMZ">Amazonas</option>
                        <option value="CO-VID">Vaupés</option>
                        <option value="CO-GUV">Guaviare</option>
                        <option value="CO-GUA">Guainía</option>
                        <option value="CO-VIC">Vichada</option>
                        <option value="CO-SAP">San Andrés</option>
                    </x-shop::form.control-group.control>
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.checkout.onepage.address.form.state.after') !!}
            </div>

            {{-- Ciudad y Postcode - ocultos --}}
            <div class="hidden">
                <x-shop::form.control-group>
                    <x-shop::form.control-group.control
                        type="text"
                        ::name="controlName + '.city'"
                        v-model="selectedCity"
                        :label="trans('shop::app.checkout.onepage.address.city')"
                    />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.checkout.onepage.address.form.city.after') !!}

                <x-shop::form.control-group>
                    <x-shop::form.control-group.control
                        type="text"
                        ::name="controlName + '.postcode'"
                        v-model="selectedPostcode"
                        :label="trans('shop::app.checkout.onepage.address.postcode')"
                    />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.checkout.onepage.address.form.postcode.after') !!}
            </div>

            <!-- Teléfono -->
            <x-shop::form.control-group>
                <x-shop::form.control-group.label class="required !mt-0">
                    @lang('shop::app.checkout.onepage.address.telephone')
                </x-shop::form.control-group.label>

                <x-shop::form.control-group.control
                    type="text"
                    ::name="controlName + '.phone'"
                    ::value="address.phone"
                    rules="required|phone"
                    :label="trans('shop::app.checkout.onepage.address.telephone')"
                    :placeholder="trans('shop::app.checkout.onepage.address.telephone')"
                />

                <x-shop::form.control-group.error ::name="controlName + '.phone'" />
            </x-shop::form.control-group>

            {!! view_render_event('bagisto.shop.checkout.onepage.address.form.phone.after') !!}
        </div>
    </script>

    <script type="module">
        app.component('v-checkout-address-form', {
            template: '#v-checkout-address-form-template',

            props: {
                controlName: {
                    type: String,
                    required: true,
                },

                address: {
                    type: Object,

                    default: () => ({
                        id: 0,
                        company_name: '',
                        first_name: '',
                        last_name: '',
                        email: '',
                        address: [],
                        country: 'CO',
                        state: 'CO-CUN',
                        city: 'Bogotá',
                        postcode: '110111',
                        phone: '',
                    }),
                },
            },

            data() {
                return {
                    selectedCountry: 'CO',
                    selectedState: 'CO-CUN',
                    selectedCity: 'Bogotá',
                    selectedPostcode: '110111',
                    countries: [],
                    states: null,
                }
            },

            computed: {
                haveStates() {
                    return !! this.states?.[this.selectedCountry]?.length;
                },
            },

            mounted() {
                this.getCountries();
                this.getStates();
            },

            methods: {
                getCountries() {
                    this.$axios.get("{{ route('shop.api.core.countries') }}")
                        .then(response => {
                            this.countries = response.data.data;
                        })
                        .catch(() => {});
                },

                getStates() {
                    this.$axios.get("{{ route('shop.api.core.states') }}")
                        .then(response => {
                            this.states = response.data.data;
                        })
                        .catch(() => {});
                },
            }
        });
    </script>
@endPushOnce