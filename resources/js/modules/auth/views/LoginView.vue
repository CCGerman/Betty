<template>
  <div class="d-flex align-items-center justify-content-center card-container">
    <div class="card my-5">
      <form class="card-body cardbody-color p-lg-5">
        <div class="text-center">
          <img
            src="/storage/logo.jpg"
            class="
              img-fluid
              profile-image-pic
              img-thumbnail
              rounded-circle
              my-3
            "
            width="200px"
            alt="logo"
          />
        </div>

        <div class="mb-3">
          <input
            type="email"
            class="form-control"
            id="email"
            aria-describedby="emailHelp"
            placeholder="email"
            v-model="email"
          />
        </div>
        <div class="mb-3">
          <input
            type="password"
            class="form-control"
            id="password"
            placeholder="constraseña"
            v-model="password"
          />
        </div>
        <div class="text-center">
          <button @click="submitForm" class="btn btn-color px-5 mb-2 w-100">
            Login
          </button>
        </div>
      </form>
    </div>
  </div>
  <div v-show="message" class="mt-3 text-center" id="alert">
    <div class="alert alert-danger" role="alert">
      {{ message }}
    </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";
export default {
  props: {
    lastView: {
      type: String,
      default: 'home'
    }
  },
  data() {
    return {
      message: "",
      email: '',
      password: ''
    };
  },
  methods: {
    ...mapActions("auth", ["recoverKeyFromLocal", "getApiKey"]),
    async submitForm(event) {
      this.message = ""
      event.preventDefault();
      if (this.email && this.password) {
        if (
          await this.getApiKey({
            email : this.email,
            password : this.password,
          })
        )
          this.$router.push({ name: this.lastView })        
        else {
          this.message = "Datos incorrectos"
        }
      } else {
        this.message = 'Los campos no pueden estar vacíos'
      }
    },
  },
  async mounted() {
    const response = await this.recoverKeyFromLocal()
    if (response) this.$router.push({ name: this.lastView });
  },
}
</script>

<style scoped>
.card-container {
  width: 100vw;
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  background-color: rgb(247, 248, 255);
}

.card {
  max-width: 500px;
}

.btn-color {
  background-color: #5262c8;
  color: #fff;
}

.profile-image-pic {
  height: 200px;
  width: 200px;
  object-fit: cover;
}

.cardbody-color {
  background-color: #ebf2fa;
}

a {
  text-decoration: none;
}

#alert{
  animation: hideMe 1s ease-in 2s forwards;
}

@keyframes hideMe {
  0%{
    visibility: visible;
    opacity: 1;
  }
  100% {
    visibility: hidden;
    opacity: 0;
  }

}

</style>