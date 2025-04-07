<template>
  <div class="wrapper min-vh-100 d-flex flex-row align-items-center">
    <CContainer>
      <CRow class="justify-content-center">
        <CCol :md="8">
          <CCardGroup>
            <CCard class="p-4">
              <CCardBody>
                <CForm>
                  <h1>Login</h1>
                  <p class="text-body-secondary">Sign In to your account</p>
                  <CInputGroup class="mb-3">
                    <CInputGroupText>
                      <CIcon icon="cil-user" />
                    </CInputGroupText>
                    <CFormInput
                      placeholder="Email"
                      autocomplete="username"
                      v-model="formData.email"
                      />
                    </CInputGroup>
                    <p class="text-danger" v-if="errors.email">{{ errors.email[0] }}</p>
                  <CInputGroup class="mb-4">
                    <CInputGroupText>
                      <CIcon icon="cil-lock-locked" />
                    </CInputGroupText>
                    <CFormInput
                      type="password"
                      placeholder="Password"
                      autocomplete="current-password"
                      v-model="formData.password"
                    />
                </CInputGroup>
                <p class="text-danger" v-if="errors.password">{{ errors.password[0] }}</p>
                  <CRow>
                    <CCol :xs="6">
                      <CButton color="primary" class="px-4" @click="handleLogin(formData)"> Login </CButton>
                    </CCol>
                    <CCol :xs="6" class="text-right">
                      <CButton color="link" class="px-0">
                        Forgot password?
                      </CButton>
                    </CCol>
                  </CRow>
                </CForm>
              </CCardBody>
            </CCard>
            <CCard class="text-white bg-primary py-5" style="width: 44%">
              <CCardBody class="text-center">
                <div>
                  <h2>Sign up</h2>
                  <p>
                    <!-- Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                    sed do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua. -->
                    Admin Panel For Social Network
                  </p>
                  <!-- <CButton @click="router.push({name: 'register'})" color="light" variant="outline" class="mt-3">
                    Register Now!
                  </CButton> -->
                </div>
              </CCardBody>
            </CCard>
          </CCardGroup>
        </CCol>
      </CRow>
    </CContainer>
  </div>
</template>
<script setup>
import { reactive } from 'vue';
import router from '../router';
import { useAuthStore } from '../store/auth';
import { storeToRefs } from 'pinia';

const auth = useAuthStore()
const { errors } = storeToRefs(auth)

const formData = reactive({
    email:'',
    password:''
})

const handleLogin = async () => {
    await auth.login(formData)
    formData.email = ''
    formData.password = ''
}

</script>