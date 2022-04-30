<template>
  <table class="table text-center mw-900">
  <thead>
    <tr class="table-dark">
      <th scope="col"></th>
      <th scope="col">Nombre</th>
      <th scope="col">Precio</th>
      <th scope="col">Duración</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(treatment, index) in treatments"
    :key="treatment.id"
    class="align-middle"
    :class="{ 'alt-row' : index%2 != 0 }">
      <td v-if="treatment.active" class="text-info"><i class="fa-solid fa-thumbs-up"></i></td>
      <td v-else class="text-muted"><i class="fa-solid fa-thumbs-down"></i></td>
      <td>{{ treatment.name }}</td>
      <td>{{ getCurrency(treatment.price) }}</td>
      <td>{{ treatment.duration }} min.</td>
      <td class="text-center">
        <button v-if="treatment.active" class="btn btn-primary" @click="$emit('view', treatment.id)">
          <i class="fa-solid fa-eye"></i>
        </button>
        <button v-else class="btn btn-outline-primary" @click="$emit('view', treatment.id)">
          <i class="fa-solid fa-eye"></i>
        </button>
      </td>
    </tr>
  </tbody>
</table>
</template>

<script>
export default {
    props: {
        treatments: {
            type: Array,
            required: true,
            default: []
        }
    },
    methods: {
      getCurrency(price){
        return price.toFixed(2)+' €';
      }
    }
}
</script>

<style>
  .alt-row{
    background-color: #e4e7ff;
  }

  .mw-900{
    max-width: 900px;
    margin: 0 auto;
  }
</style>