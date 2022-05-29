<template>
  <table class="table mw-900">
  <thead>
    <tr class="table-dark">
      <th scope="col"></th>
      <th scope="col" class="pb-3">Nombre</th>
      <th scope="col" class="pb-3">Apellidos</th>
      <th scope="col" class="d-flex justify-content-center">
        <button class="btn btn-outline-primary" @click="$emit('new')">Nuevo</button>
      </th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(worker, index) in workers"
    :key="worker.id"
    class="align-middle"
    :class="{ 'alt-row' : index%2 != 0 }">
      <td v-if="worker.active" class="text-info"><i class="fa-solid fa-thumbs-up"></i></td>
      <td v-else class="text-muted"><i class="fa-solid fa-thumbs-down"></i></td>
      <td>{{ worker.name }}</td>
      <td>{{ worker.last_name_1 }} {{ worker.last_name_2 }}</td>
      <td class="text-center">
        <button v-if="worker.active" class="btn btn-primary" @click="$emit('view', worker.id)">
          <i class="fa-solid fa-eye"></i>
        </button>
        <button v-else class="btn btn-outline-primary" @click="$emit('view', worker.id)">
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
        workers: {
            type: Array,
            required: true,
            default: []
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