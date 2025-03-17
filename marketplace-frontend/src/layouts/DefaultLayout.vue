<template>
  <div class="min-h-screen bg-gray-50">
    <Header />
    <main class="pt-16 pb-16 md:pb-0">
      <slot></slot>
    </main>
    <BottomNav />
  </div>
</template>

<script>
import Header from '../views/components/Header.vue'
import BottomNav from '../views/components/BottomNav.vue'

export default {
  name: 'DefaultLayout',
  components: {
    Header,
    BottomNav
  }
}
</script> 