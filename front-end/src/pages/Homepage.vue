<template>
  <q-page class="flex flex-center">
    <div class="q-pa-md">
    <div class="text-purple q-gutter-md">
      <q-icon
        
        v-for="size in ['200px']"
        :key="size"
        :size="size"
        name="question_answer"
        color="positive"
      />
      <h3

      color="positive">
      SOCIAL APP</h3>
    </div>
    <div class="col-12 col-md-12 col-lg-12 text-center">
                <router-link to="/login" style="text-decoration: none; color: blue; .shadow-3;">LOGIN/SIGNUP</router-link>
              </div>
  </div>
  </q-page>
</template>

<script>
export default {
  name: 'PageIndex'
}
</script>
