<script setup>
import avatar1 from '@/assets/images/avatars/1.jpg'
import avatar2 from '@/assets/images/avatars/2.jpg'
import avatar3 from '@/assets/images/avatars/3.jpg'
import avatar4 from '@/assets/images/avatars/4.jpg'
import avatar5 from '@/assets/images/avatars/5.jpg'
import avatar6 from '@/assets/images/avatars/6.jpg'
import MainChart from './MainChart.vue'
import WidgetsStatsA from './../widgets/WidgetsStatsTypeA.vue'
import WidgetsStatsD from './../widgets/WidgetsStatsTypeD.vue'
import { onMounted, reactive } from 'vue'
import axios from 'axios'

const progressGroupExample1 = [
  { title: 'Monday', value1: 34, value2: 78 },
  { title: 'Tuesday', value1: 56, value2: 94 },
  { title: 'Wednesday', value1: 12, value2: 67 },
  { title: 'Thursday', value1: 43, value2: 91 },
  { title: 'Friday', value1: 22, value2: 73 },
  { title: 'Saturday', value1: 53, value2: 82 },
  { title: 'Sunday', value1: 9, value2: 69 },
]
const progressGroupExample2 = [
  { title: 'Male', icon: 'cil-user', value: 53 },
  { title: 'Female', icon: 'cil-user-female', value: 43 },
]
const progressGroupExample3 = [
  {
    title: 'Organic Search',
    icon: 'cib-google',
    percent: 56,
    value: '191,235',
  },
  { title: 'Facebook', icon: 'cib-facebook', percent: 15, value: '51,223' },
  { title: 'Twitter', icon: 'cib-twitter', percent: 11, value: '37,564' },
  { title: 'LinkedIn', icon: 'cib-linkedin', percent: 8, value: '27,319' },
]
const tableExample = [
  // {
  //   avatar: { src: avatar1, status: 'success' },
  //   user: {
  //     name: 'Yiorgos Avraamu',
  //     new: true,
  //     registered: 'Jan 1, 2023',
  //   },
  //   country: { name: 'USA', flag: 'cif-us' },
  //   usage: {
  //     value: 50,
  //     period: 'Jun 11, 2023 - Jul 10, 2023',
  //     color: 'success',
  //   },
  //   payment: { name: 'Mastercard', icon: 'cib-cc-mastercard' },
  //   activity: '10 sec ago',
  // },
  // {
  //   avatar: { src: avatar2, status: 'danger' },
  //   user: {
  //     name: 'Avram Tarasios',
  //     new: false,
  //     registered: 'Jan 1, 2023',
  //   },
  //   country: { name: 'Brazil', flag: 'cif-br' },
  //   usage: {
  //     value: 22,
  //     period: 'Jun 11, 2023 - Jul 10, 2023',
  //     color: 'info',
  //   },
  //   payment: { name: 'Visa', icon: 'cib-cc-visa' },
  //   activity: '5 minutes ago',
  // },
  // {
  //   avatar: { src: avatar3, status: 'warning' },
  //   user: { name: 'Quintin Ed', new: true, registered: 'Jan 1, 2023' },
  //   country: { name: 'India', flag: 'cif-in' },
  //   usage: {
  //     value: 74,
  //     period: 'Jun 11, 2023 - Jul 10, 2023',
  //     color: 'warning',
  //   },
  //   payment: { name: 'Stripe', icon: 'cib-cc-stripe' },
  //   activity: '1 hour ago',
  // },
  // {
  //   avatar: { src: avatar4, status: 'secondary' },
  //   user: { name: 'Enéas Kwadwo', new: true, registered: 'Jan 1, 2023' },
  //   country: { name: 'France', flag: 'cif-fr' },
  //   usage: {
  //     value: 98,
  //     period: 'Jun 11, 2023 - Jul 10, 2023',
  //     color: 'danger',
  //   },
  //   payment: { name: 'PayPal', icon: 'cib-cc-paypal' },
  //   activity: 'Last month',
  // },
  // {
  //   avatar: { src: avatar5, status: 'success' },
  //   user: {
  //     name: 'Agapetus Tadeáš',
  //     new: true,
  //     registered: 'Jan 1, 2023',
  //   },
  //   country: { name: 'Spain', flag: 'cif-es' },
  //   usage: {
  //     value: 22,
  //     period: 'Jun 11, 2023 - Jul 10, 2023',
  //     color: 'primary',
  //   },
  //   payment: { name: 'Google Wallet', icon: 'cib-cc-apple-pay' },
  //   activity: 'Last week',
  // },
  // {
  //   avatar: { src: avatar6, status: 'danger' },
  //   user: {
  //     name: 'Friderik Dávid',
  //     new: true,
  //     registered: 'Jan 1, 2023',
  //   },
  //   country: { name: 'Poland', flag: 'cif-pl' },
  //   usage: {
  //     value: 43,
  //     period: 'Jun 11, 2023 - Jul 10, 2023',
  //     color: 'success',
  //   },
  //   payment: { name: 'Amex', icon: 'cib-cc-amex' },
  //   activity: 'Last week',
  // },
]
const dashboardData = reactive({
  posts:0,
  likes:0,
  user:0,
  comments:0,
  users:[]
})
onMounted( async () => {
  try {
    const res =  await axios.get('/api/admin/dashboard', {
      headers:{
        Authorization: `Bearer ${localStorage.getItem('token')}`
      }
    })
    if(res.status == 200)
    {
      dashboardData.posts = res.data.posts == 0 ? '0' : res.data.posts
      dashboardData.likes = res.data.likes == 0 ? '0' : res.data.likes
      dashboardData.user = res.data.users == 0 ? '0' : res.data.users
      dashboardData.comments = res.data.comments == 0 ? '0' : res.data.comments
      dashboardData.users = res.data.latestUsers
      console.log(dashboardData);
      
    }
  } catch (error) {
      console.log(error);
  }
})
</script>

<template>
  <div>
    <WidgetsStatsA class="mb-4" :dashboardData="dashboardData" />
    <!-- <CRow>
      <CCol :md="12">
        <CCard class="mb-4">
          <CCardBody>
            <CRow>
              <CCol :sm="5">
                <h4 id="traffic" class="card-title mb-0">Traffic</h4>
                <div class="small text-body-secondary">January - July 2023</div>
              </CCol>
              <CCol :sm="7" class="d-none d-md-block">
                <CButton color="primary" class="float-end">
                  <CIcon icon="cil-cloud-download" />
                </CButton>
                <CButtonGroup
                  class="float-end me-3"
                  role="group"
                  aria-label="Basic outlined example"
                >
                  <CButton color="secondary" variant="outline">Day</CButton>
                  <CButton color="secondary" variant="outline" active>Month</CButton>
                  <CButton color="secondary" variant="outline">Year</CButton>
                </CButtonGroup>
              </CCol>
            </CRow>
            <CRow>
              <MainChart style="height: 300px; max-height: 300px; margin-top: 40px" />
            </CRow>
          </CCardBody>
          <CCardFooter>
            <CRow
              :xs="{ cols: 1, gutter: 4 }"
              :sm="{ cols: 2 }"
              :lg="{ cols: 4 }"
              :xl="{ cols: 5 }"
              class="mb-2 text-center"
            >
              <CCol>
                <div class="text-body-secondary">Visits</div>
                <div class="fw-semibold text-truncate">29.703 Users (40%)</div>
                <CProgress class="mt-2" color="success" thin :precision="1" :value="40" />
              </CCol>
              <CCol>
                <div class="text-body-secondary">Unique</div>
                <div class="fw-semibold text-truncate">24.093 Users (20%)</div>
                <CProgress class="mt-2" color="info" thin :precision="1" :value="20" />
              </CCol>
              <CCol>
                <div class="text-body-secondary">Pageviews</div>
                <div class="fw-semibold text-truncate">78.706 Views (60%)</div>
                <CProgress class="mt-2" color="warning" thin :precision="1" :value="60" />
              </CCol>
              <CCol>
                <div class="text-body-secondary">New Users</div>
                <div class="fw-semibold text-truncate">22.123 Users (80%)</div>
                <CProgress class="mt-2" color="danger" thin :precision="1" :value="80" />
              </CCol>
              <CCol class="d-none d-xl-block">
                <div class="text-body-secondary">Bounce Rate</div>
                <div class="fw-semibold text-truncate">Average Rate (40.15%)</div>
                <CProgress class="mt-2" :value="40" thin :precision="1" />
              </CCol>
            </CRow>
          </CCardFooter>
        </CCard>
      </CCol>
    </CRow> -->
    <!-- <WidgetsStatsD class="mb-4" /> -->
    <CRow>
      <CCol :md="12">
        <CCard class="mb-4">
          <CCardHeader> Latest Users </CCardHeader>
          <CCardBody>
            <!-- <CRow>
              <CCol :sm="12" :lg="6">
                <CRow>
                  <CCol :xs="6">
                    <div class="border-start border-start-4 border-start-info py-1 px-3 mb-3">
                      <div class="text-body-secondary small">New Clients</div>
                      <div class="fs-5 fw-semibold">9,123</div>
                    </div>
                  </CCol>
                  <CCol :xs="6">
                    <div class="border-start border-start-4 border-start-danger py-1 px-3 mb-3">
                      <div class="text-body-secondary small">Recurring Clients</div>
                      <div class="fs-5 fw-semibold">22,643</div>
                    </div>
                  </CCol>
                </CRow>
                <hr class="mt-0" />
                <div
                  v-for="item in progressGroupExample1"
                  :key="item.title"
                  class="progress-group mb-4"
                >
                  <div class="progress-group-prepend">
                    <span class="text-body-secondary small">{{ item.title }}</span>
                  </div>
                  <div class="progress-group-bars">
                    <CProgress thin color="info" :value="item.value1" />
                    <CProgress thin color="danger" :value="item.value2" />
                  </div>
                </div>
              </CCol>
              <CCol :sm="12" :lg="6">
                <CRow>
                  <CCol :xs="6">
                    <div class="border-start border-start-4 border-start-warning py-1 px-3 mb-3">
                      <div class="text-body-secondary small">Pageviews</div>
                      <div class="fs-5 fw-semibold">78,623</div>
                    </div>
                  </CCol>
                  <CCol :xs="6">
                    <div class="border-start border-start-4 border-start-success py-1 px-3 mb-3">
                      <div class="text-body-secondary small">Organic</div>
                      <div class="fs-5 fw-semibold">49,123</div>
                    </div>
                  </CCol>
                </CRow>
                <hr class="mt-0" />
                <div v-for="item in progressGroupExample2" :key="item.title" class="progress-group">
                  <div class="progress-group-header">
                    <CIcon :icon="item.icon" class="me-2" size="lg" />
                    <span class="title">{{ item.title }}</span>
                    <span class="ms-auto fw-semibold">{{ item.value }}%</span>
                  </div>
                  <div class="progress-group-bars">
                    <CProgress thin :value="item.value" color="warning" />
                  </div>
                </div>

                <div class="mb-5"></div>

                <div v-for="item in progressGroupExample3" :key="item.title" class="progress-group">
                  <div class="progress-group-header">
                    <CIcon :icon="item.icon" class="me-2" size="lg" />
                    <span class="title">{{ item.title }}</span>
                    <span class="ms-auto fw-semibold">
                      {{ item.value }}
                      <span class="text-body-secondary small">({{ item.percent }}%)</span>
                    </span>
                  </div>
                  <div class="progress-group-bars">
                    <CProgress thin :value="item.percent" color="success" />
                  </div>
                </div>
              </CCol>
            </CRow> -->
            <!-- <br /> -->
            <CTable align="middle" class="mb-0 border" hover responsive>
              <CTableHead class="text-nowrap">
                <CTableRow>
                  <CTableHeaderCell class="bg-body-secondary text-center">
                    <CIcon name="cil-people" />
                  </CTableHeaderCell>
                  <CTableHeaderCell class="bg-body-secondary"> User </CTableHeaderCell>
                  <CTableHeaderCell class="bg-body-secondary text-center">
                    Email
                  </CTableHeaderCell>
                  <CTableHeaderCell class="bg-body-secondary"> Privacy </CTableHeaderCell>
                  <CTableHeaderCell class="bg-body-secondary text-center">
                    Gender
                  </CTableHeaderCell>
                  <CTableHeaderCell class="bg-body-secondary"> Status </CTableHeaderCell>
                </CTableRow>
              </CTableHead>
              <CTableBody>
                <CTableRow v-for="item in dashboardData.users" :key="item.name">
                  <CTableDataCell class="text-center">
                    <CAvatar size="md" :src="item.image_url" />
                  </CTableDataCell>
                  <CTableDataCell>
                    <div>{{ item.username }}</div>
                    <div class="small text-body-secondary text-nowrap">
                    </div>
                  </CTableDataCell>
                  <CTableDataCell class="text-center">
                     <span>{{ item.email }}</span>
                  </CTableDataCell>
                  <CTableDataCell>
                    <div class="d-flex justify-content-between align-items-baseline">
                      <div class="text-nowrap text-body-secondary small ms-3">
                        {{ item.privacy_name }}
                      </div>
                    </div>
                  </CTableDataCell>
                  <CTableDataCell class="text-center">
                     <span>{{ item.gender_name }}</span>
                  </CTableDataCell>
                  <CTableDataCell>
                    <div class="fw-semibold text-nowrap">
                      <CBadge color="warning" v-if="item.is_suspended">Suspended</CBadge>
                      <CBadge color="danger" v-else-if="item.is_banned">Banned</CBadge>
                      <CBadge color="success" v-else>Active</CBadge>
                    </div>
                  </CTableDataCell>
                </CTableRow>
              </CTableBody>
            </CTable>
          </CCardBody>
        </CCard>
      </CCol>
    </CRow>
  </div>
</template>
