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
    "
  >
    <div
      class="bg-white m-auto p-4 col-11 col-sm-10 col-md-8 col-lg-4 col-xl-3"
    >
      <div class="row mb-2 justify-content-between align-vertical">
        <h3 class="col-8 my-1">{{ title }}</h3>
        <button
          v-if="treatment.id"
          class="btn btn-outline-danger col-2"
          @click="deleteTreatment"
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
          v-model="treatment.name"
          aria-describedby="name-addon"
        />
        <div v-if="errors.name" class="invalid-feedback">
          {{ errors.name }}
        </div>
      </div>
      <div class="input-group mb-3">
        <div class="row">
          <div class="input-grup col-4">
            <label for="duration" class="form-label">duration</label>
            <input
              type="text"
              class="form-control"
              id="duration"
              :class="{ 'is-invalid': errors.duration }"
              placeholder="duration"
              v-model="treatment.duration"
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
                v-model="treatment.price"
              />
              <div class="py-2 ms-2">€</div>
            </div>
          </div>
        </div>
        <div v-if="errors.duration" class="invalid-feedback d-block">
          {{ errors.duration }}
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
          v-model="treatment.description"
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
            v-model="treatment.active"
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
              @click="saveTreatment"
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
import { Treatment } from "../../../helpers/Treatment.js";

export default {
  data() {
    return {
      errors: [],
    };
  },
  props: {
    treatment: {
      type: Treatment,
      required: true,
      default: new Treatment({}),
    },
  },
  methods: {
    deleteTreatment() {
      Swal.fire({
        title: "¿Eliminar el tratamiento?",
        text: "Esta opción no se puede deshacer",
        icon: "warning",
        showCancelButton: true,
        cancelButtonColor: "#3085d6",
        confirmButtonColor: "#d33",
        confirmButtonText: "¡Eliminar!",
        cancelButtonText: "Volver",
      }).then((result) => {
        if (result.isConfirmed) {
          this.$emit("deleteTreatment", this.treatment.id);
        }
      });
    },
    validateForm() {
      this.errors = {};
      if (!this.treatment.name) {
        this.errors.name = "El nombre es obligatorio.";
      }

      if (!this.treatment.description) {
        this.errors.description = "Indique una descripción.";
      }

      if (!this.treatment.duration) {
        this.errors.duration = "El duration es obligatorio.";
      } else if (isNaN(this.treatment.duration) || parseFloat(this.treatment.duration) != this.treatment.duration) {
        this.errors.duration = "La duración debe ser un número";
      }

      if (!this.treatment.price) {
        this.errors.price = "El precio es obligatorio.";
      } else if (isNaN(this.treatment.price) || parseFloat(this.treatment.price) != this.treatment.price) {
        this.errors.price = "El precio debe ser un número";
      }

      if (Object.keys(this.errors).length == 0) return true;
      else return false;
    },
    saveTreatment() {
      if (this.validateForm()) {
        this.$emit("saveTreatment");
      }
    },
  },
  computed: {
    title() {
      if (this.treatment.id) return "Editar tratamiento";
      else return "Nuevo tratamiento";
    },
  },
};
</script>

<style>
.bg-80 {
  background-color: rgba(0, 0, 0, 0.8);
}
</style>