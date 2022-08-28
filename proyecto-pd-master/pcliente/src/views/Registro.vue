<template>
  <div class="auth-wrapper auth-v1 px-2">
    <div class="auth-inner py-2">

      <!-- Register v1 -->
      <b-card class="mb-0">
        <b-link class="brand-logo">
          <h2 class="brand-text text-primary ml-1">
            PAYDAY
          </h2>
        </b-link>

        <b-card-title class="mb-1">
            Empieza una nueva aventura 🚀
        </b-card-title>
        <b-card-text class="mb-2">
            Pagaras servicios de manera mas facil
        </b-card-text>

        <!-- form -->
        <validation-observer ref="registerForm">
          <b-form
            class="auth-register-form mt-2"
            @submit.prevent="validationForm"
          >
            <!-- username -->
            <b-form-group
              label="Nombre y Apelllido"
              label-for="nombre"
            >
              <validation-provider
                #default="{ errors }"
                name="Nombre"
                rules="required"
              >
                <b-form-input
                  id="nombre"
                  v-model="nombre"
                  :state="errors.length > 0 ? false:null"
                  name="register-nombre"
                  placeholder="Cristian"
                />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>

            <!-- Documento -->
            <b-form-group
              label="Documento"
              label-for="documento"
            >
              <validation-provider
                #default="{ errors }"
                name="Documento"
                rules="required"
              >
                <b-form-input
                  id="documento"
                  v-model="documento"
                  :state="errors.length > 0 ? false:null"
                  name="register-documento"
                  placeholder="51294519"
                />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>
            <!-- email -->
            <b-form-group
              label="Email"
              label-for="email"
            >
              <validation-provider
                #default="{ errors }"
                name="Email"
                rules="required|email"
              >
                <b-form-input
                  id="email"
                  v-model="regEmail"
                  :state="errors.length > 0 ? false:null"
                  name="register-email"
                  placeholder="john@example.com"
                />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>

            <!-- password -->
            <b-form-group
              label="Password"
              label-for="password"
            >
              <validation-provider
                #default="{ errors }"
                name="Password"
                rules="required"
              >
                <b-input-group
                  class="input-group-merge"
                  :class="errors.length > 0 ? 'is-invalid':null"
                >
                  <b-form-input
                    id="password"
                    v-model="password"
                    :type="passwordFieldType"
                    :state="errors.length > 0 ? false:null"
                    class="form-control-merge"
                    name="register-password"
                    placeholder="············"
                  />
                  <b-input-group-append is-text>
                    <feather-icon
                      :icon="passwordToggleIcon"
                      class="cursor-pointer"
                      @click="togglePasswordVisibility"
                    />
                  </b-input-group-append>
                </b-input-group>
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>

            <!-- checkbox -->
            <b-form-group>
              <b-form-checkbox
                id="register-privacy-policy"
                v-model="status"
                name="checkbox-1"
              >
                Acepto los
                <b-link>terminos y condiciones</b-link>
              </b-form-checkbox>
            </b-form-group>

            <!-- submit button -->
            <b-button
              variant="primary"
              block
              type="submit"
            >
              Registrarme
            </b-button>
          </b-form>
        </validation-observer>

        <b-card-text class="text-center mt-2">
          <span>Ya tienes una cuenta? </span>
          <b-link :to="{name:'login'}">
            <span>Inicia sesion</span>
          </b-link>
        </b-card-text>

      </b-card>
    <!-- /Register v1 -->
    </div>
  </div>

</template>

<script>
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import axios from 'axios'
import {
  BCard, BLink, BCardTitle, BCardText, BForm,
  BButton, BFormInput, BFormGroup, BInputGroup, BInputGroupAppend, BFormCheckbox,
} from 'bootstrap-vue'
import { required, email } from '@validations'
import { togglePasswordVisibility } from '@core/mixins/ui/forms'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { useRouter } from 'vue-router';

export default {
  setup() {
    const submit = async e => {
      const router = useRouter();
      const form = new FormData(e.target);
      const inputs = Object.fromEntries(form.entries());
      await axios.post('/registro', inputs);
      await router.push('/login');
    }
    return { submit }
  },
  components: {
    // BSV
    BCard,
    BLink,
    BCardTitle,
    BCardText,
    BForm,
    BButton,
    BFormInput,
    BFormGroup,
    BInputGroup,
    BInputGroupAppend,
    BFormCheckbox,
    // validations
    ValidationProvider,
    ValidationObserver,
  },
  mixins: [togglePasswordVisibility],
  data() {
    return {
      regEmail: '',
      username: '',
      password: '',
      status: '',

      // validation rules
      required,
      email,
    }
  },
  computed: {
    passwordToggleIcon() {
      return this.passwordFieldType === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
  },
  methods: {
    validationForm() {
      const router = useRouter();
      router.push('/login');
      this.$refs.registerForm.validate().then(success => {
        if (success) {
          this.$toast({
            component: ToastificationContent,
            props: {
              title: 'Form Submitted',
              icon: 'EditIcon',
              variant: 'success',
            },
          })
        }
      })
    },
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/pages/page-auth.scss';
</style>
