<template>
  <logged lastView="products" />
  <page-title title="Productos" />
  <products-table v-if="products" :products="products" @view="view" />
    <button-new @new="newProduct">
    <i class="mt-3 fa-solid fa-cart-plus"></i>
  </button-new>
  <product-modal v-if="showModal" :product="activeProduct"
    @hide="showModal=false"
    @deleteProduct="deleteProduct"
    @saveProduct="saveProduct"
  />
</template>

<script>
import Logged from "../../auth/components/Logged.vue"
import PageTitle from "../../../components/PageTitle.vue"
import ProductsTable from "../components/ProductsTable.vue"
import ProductModal from '../components/ProductModal.vue'
import ButtonNew from '../../../components/ButtonNew.vue'

import { mapState } from "vuex"
import { 
  getProducts,
  getProduct,
  addProduct,
  saveProduct,
  deleteProduct 
  } from "../helpers/ProductDAO.js"
import { Product } from '../../../helpers/Product.js'

export default {
  data() {
    return {
      products: [],
      activeProduct: new Product({}),
      showModal: false
    };
  },
  components: {
    Logged,
    PageTitle,
    ProductsTable,
    ProductModal,
    ButtonNew
  },
  computed: {
    ...mapState("auth", ["apiKey"]),
  },
  methods:{
    async view(id){
      const result = await getProduct(this.apiKey, id)
      this.activeProduct = new Product( result.data )
      console.log(this.activeProduct)
      this.showModal = true
    },
    async saveProduct(){
      let response
      if(this.activeProduct.id){
        response = await saveProduct(this.apiKey, this.activeProduct)
      } else {
        response = await addProduct(this.apiKey, this.activeProduct)
      }
      console.log(response);
      this.activeProduct = new Product({});
      this.showModal = false;
      this.refreshData()
    },
    async deleteProduct(id){
      await deleteProduct(this.apiKey, id)
      this.activeProduct = new Product({})
      this.showModal = false
      this.refreshData()
    },
    async refreshData(){
      if (this.apiKey) {
        const { data } = await getProducts(this.apiKey)
        this.products = data
      }
    },
    newProduct(){
      this.activeProduct = new Product({})
      this.showModal = true
    }
  },
  mounted() {
    this.refreshData()
  },
};
</script>

<style>
</style>