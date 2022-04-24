<template>
  <table class="table mw-900">
  <thead>
    <tr class="table-dark">
      <th scope="col"></th>
      <th scope="col">Nombre</th>
      <th scope="col">Apellidos</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(client, index) in clients"
    :key="client.id"
    class="align-middle"
    :class="{ 'alt-row' : index%2 != 0 }">
      <td v-if="client.active" class="text-info"><i class="fa-solid fa-thumbs-up"></i></td>
      <td v-else class="text-muted"><i class="fa-solid fa-thumbs-down"></i></td>
      <td>{{ client.name }}</td>
      <td>{{ client.last_name_1 }} {{ client.last_name_2 }}</td>
      <td class="text-center">
        <button v-if="client.active" class="btn btn-primary" @click="$emit('view', client.id)">
          <i class="fa-solid fa-eye"></i>
        </button>
        <button v-else class="btn btn-outline-primary" @click="$emit('view', client.id)">
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
        clients: {
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