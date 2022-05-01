<template>
  <div
    class="
      w-100
      h-100
      position-fixed
      top-0
      start-0
      bg-80
      d-flex
      align-middle
      overflow-scroll
      py-5
      modal-element
    "
  >
    <div
      class="bg-white m-auto p-4 col-11 col-sm-10 col-md-8 col-lg-4 col-xl-3"
    >
      <div class="row mb-2 justify-content-between align-vertical">
        <h3 class="col-8 my-1">{{ title }}</h3>
        <button
          v-if="product.id"
          class="btn btn-outline-danger col-2"
          @click="deleteProduct"
        >
          <i class="fa-solid fa-trash"></i>
        </button>
      </div>
      <div class="input-group mb-3">
        <span class="input-group-text col-12 col-sm-4" id="name-addon"
          >Nombre</span
        >
        <input
          type="text"
          class="form-control"
          :class="{ 'is-invalid': errors.name }"
          id="name"
          placeholder="Nombre"
          v-model="product.name"
          aria-describedby="name-addon"
        />
        <div v-if="errors.name" class="invalid-feedback">
          {{ errors.name }}
        </div>
      </div>
      <div class="input-group mb-3">
        <div class="row">
          <div class="input-grup col-4">
            <label for="stock" class="form-label">Stock</label>
            <input
              type="text"
              class="form-control"
              id="stock"
              :class="{ 'is-invalid': errors.stock }"
              placeholder="stock"
              v-model="product.stock"
            />
          </div>
          <div class="input-grup col-8">
            <label for="price" class="form-label">Precio</label>
            <div class="d-flex">
              <input
                type="text"
                class="form-control"
                id="price"
                :class="{ 'is-invalid': errors.price }"
                placeholder="precio"
                v-model="product.price"
              />
              <div class="py-2 ms-2">€</div>
            </div>
          </div>
        </div>
        <div v-if="errors.stock" class="invalid-feedback d-block">
          {{ errors.stock }}
        </div>
        <div v-if="errors.price" class="invalid-feedback d-block">
          {{ errors.price }}
        </div>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Descripción</label>
        <textarea
          name="description"
          id="description"
          v-model="product.description"
          placeholder="Descripcion"
          class="form-control"
          :class="{ 'is-invalid': errors.descripcion }"
        ></textarea>
        <div v-if="errors.description" class="invalid-feedback">
          {{ errors.description }}
        </div>
      </div>
      <div class="d-flex justify-content-between">
        <div class="form-check d-flex align-middle">
          <input
            class="form-check-input"
            type="checkbox"
            id="active"
            v-model="product.active"
            true-value="1"
            false-value="0"
          />
          <label for="active" class="ps-2 form-check-label"
            >Activo</label
          >
        </div>
        <div class="buttons">
          <div class="row mt-2">
            <button
              class="btn btn-success d-flex justify-content-evenly col-5 me-2"
              @click="saveProduct"
            >
              <i class="py-1 fa-solid fa-circle-check"></i>
              <span class="d-none d-md-block">Guardar</span>
            </button>
            <button
              class="btn btn-secondary d-flex justify-content-evenly col-5"
              @click="$emit('hide')"
            >
              <i class="py-1 fa-solid fa-right-from-bracket"></i>
              <span class="d-none d-md-block">Salir</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Swal from "sweetalert2";
import { Product } from "../../../helpers/Product.js";

export default {
  data() {
    return {
      errors: [],
    };
  },
  props: {
    product: {
      type: Product,
      required: true,
      default: new Product({}),
    },
  },
  methods: {
    deleteProduct() {
      Swal.fire({
        title: "¿Eliminar el producto?",
        text: "Esta opción no se puede deshacer",
        icon: "warning",
        showCancelButton: true,
        cancelButtonColor: "#3085d6",
        confirmButtonColor: "#d33",
        confirmButtonText: "¡Eliminar!",
        cancelButtonText: "Volver",
      }).then((result) => {
        if (result.isConfirmed) {
          this.$emit("deleteProduct", this.product.id);
        }
      });
    },
    validateForm() {
      this.errors = {};
      if (!this.product.name) {
        this.errors.name = "El nombre es obligatorio.";
      }

      if (!this.product.description) {
        this.errors.description = "Indique una descripción.";
      }

      if (!this.product.stock) {
        this.errors.stock = "El stock es obligatorio.";
      } else if (isNaN(this.product.stock) || parseFloat(this.product.stock) != this.product.stock) {
        this.errors.stock = "El stock debe ser un número";
      }

      if (!this.product.price) {
        this.errors.price = "El precio es obligatorio.";
      } else if (isNaN(this.product.price) || parseFloat(this.product.price) != this.product.price) {
        this.errors.price = "El precio debe ser un número";
      }

      if (Object.keys(this.errors).length == 0) return true;
      else return false;
    },
    saveProduct() {
      if (this.validateForm()) {
        this.$emit("saveProduct");
      }
    },
  },
  computed: {
    title() {
      if (this.product.id) return "Editar producto";
      else return "Nuevo producto";
    },
  },
};
</script>

<style>
.bg-80 {
  background-color: rgba(0, 0, 0, 0.8);
}
</style>