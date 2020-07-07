<template>
  <div class="no">
    <c-header :title="$route.name" />

    <!-- Main content -->

    <section class="content"></section>

    <!-- /.content -->
  </div>
</template>

<script>
import CHeader from '../components/Header';

export default {
  components: {
    CHeader,
  },
};
</script>
