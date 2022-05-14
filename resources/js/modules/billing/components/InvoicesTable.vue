<template>
  <table class="table mw-900">
  <thead>
    <tr class="table-dark">
      <th scope="col">Num.</th>
      <th scope="col">Fecha</th>
      <th scope="col">Cliente</th>
      <th scope="col">Importe</th>
      <th scope="col">Pendiente</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(invoice, index) in invoices"
    :key="invoice.id"
    class="align-middle"
    :class="{ 'alt-row' : index%2 != 0 }">
      <td>{{ invoice.serie }}-{{ invoice.number }}</td>
      <td>{{ invoice.date }}</td>
      <td>{{ invoice.client.last_name_1 }} {{ invoice.client.last_name_2 }}</td>      
      <td>{{ invoice.total_amount }}</td>
      <td>{{ invoice.balance }}</td>

      <td class="text-center">
        <button class="btn btn-primary" @click="$emit('view', invoice.id )">
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
        invoices: {
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