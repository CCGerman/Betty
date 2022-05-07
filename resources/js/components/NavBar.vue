<template>
  <nav v-show="logged" id="sidebar" class="min-vh-100">
    <div class="custom-menu">
      <button type="button" id="sidebarCollapse" class="btn btn-primary">
        <i class="fa fa-bars"></i>
        <span class="sr-only"></span>
      </button>
    </div>
    <div class="px-4 pb-4" id="menu-content">
      <h1 class="text-center">
        <a href="/" class="logo">Betty <span>Beautify me!</span></a>
      </h1>
      <ul class="list-unstyled components mb-5">
        <router-link :to="{name: 'home'}" v-slot="{ isExactActive, href, navigate }">
          <li  :class="{active:isExactActive}">
            <a :href="href" @click="navigate"><span class="fa fa-home me-2"></span> Inicio</a>
          </li>
        </router-link>
        <router-link :to="{name: 'appointments'}" v-slot="{ isExactActive, href, navigate }">
          <li  :class="{active:isExactActive}">
            <a :href="href" @click="navigate"><span class="fa fa-calendar me-2"></span> Citas</a>
          </li>
        </router-link>
        <router-link :to="{name: 'billing'}" v-slot="{ isExactActive, href, navigate }">
          <li  :class="{active:isExactActive}">
            <a :href="href" @click="navigate"><span class="fa fa-sticky-note me-2"></span> Facturación</a>
          </li>
        </router-link>
        <router-link :to="{name: 'clients'}" v-slot="{ isExactActive, href, navigate }">
          <li  :class="{active:isExactActive}">
            <a :href="href" @click="navigate"><span class="fa fa-user me-2"></span> Clientes</a>
          </li>
        </router-link>
        <router-link :to="{name: 'treatments'}" v-slot="{ isExactActive, href, navigate }">
          <li  :class="{active:isExactActive}">
            <a :href="href" @click="navigate"><span class="fa-solid fa-hand-holding-heart me-1">
              </span> Tratamientos</a>
          </li>
        </router-link>
        <router-link :to="{name: 'products'}" v-slot="{ isExactActive, href, navigate }">
          <li  :class="{active:isExactActive}">
            <a :href="href" @click="navigate"><span class="fas fa-gift me-2"></span> Productos</a>
          </li>
        </router-link>
        <router-link :to="{name: 'settings'}" v-slot="{ isExactActive, href, navigate }">
          <li  :class="{active:isExactActive}">
            <a :href="href" @click="navigate"><span class="fa fa-cogs me-1"></span> Editar</a>
          </li>
        </router-link>
      </ul>

      <div class="mb-5">
        <h3 class="h6 mb-3">Buscar</h3>
        <form action="#" class="subscribe-form">
          <div class="form-group d-flex">
            <div class="icon"><span class="icon-paper-plane"></span></div>
            <input type="text" class="form-control" placeholder="Buscar..." />
          </div>
        </form>
      </div>

      <div class="footer d-flex justify-content-center">
        <button @click="logMeOut()" class="btn">
          <i class="fa-solid fa-power-off"></i> Salir
        </button>
      </div>
    </div>
  </nav>
</template>

<script>
//import LogoutForm from "../components/helper/LogoutForm.vue";
import { mapActions } from 'vuex'

export default {
  components: {
    //LogoutForm,
  },
  mounted() {
    /*
    function fullHeight() {
      document.querySelector("#sidebar").style.height = window.innerHeight;
    }
    fullHeight();
    window.addEventListener("resize", fullHeight);
    */
    document
      .querySelector("#sidebarCollapse")
      .addEventListener("click", function () {
        document.querySelector("#sidebar").classList.toggle("active");
      });
  },
  methods: {
    ...mapActions('auth', ['logout']),
    async logMeOut() {
      if(await this.logout()) this.$router.push({name: 'login'})
      else console.log('no se pudo hacer logout')
    },
  },
  computed: {
    logged(){
      return this.$store.state.auth.logged
    }
  }
};
</script>

<style scoped>
#sidebar {
  min-width: 250px;
  max-width: 250px;
  background: #3445b4;
  color: #fff;
  -webkit-transition: all 0.3s;
  -o-transition: all 0.3s;
  transition: all 0.3s;
  position: relative;
}

@media (max-width:800px) {
  
  #sidebar {
    position: absolute;
    top: 0;
    left: 0;
    z-index: 10;
  }

}

#sidebar #menu-content {
  position: sticky;
  top: 20px;
}

#sidebar .h6 {
  color: #fff;
}
#sidebar.active {
  margin-left: -250px;
}
#sidebar h1 {
  margin-bottom: 20px;
  font-weight: 700;
  font-size: 30px;
}
#sidebar h1 .logo {
  color: #fff;
}
#sidebar h1 .logo span {
  font-size: 14px;
  color: #44bef1;
  display: block;
}
#sidebar ul.components {
  padding: 0;
}
#sidebar ul li {
  font-size: 16px;
}
#sidebar ul li > ul {
  margin-left: 10px;
}
#sidebar ul li > ul li {
  font-size: 14px;
}
#sidebar ul li a {
  padding: 10px 0;
  display: block;
  color: rgba(255, 255, 255, 0.6);
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}
#sidebar ul li a span {
  color: #44bef1;
}
#sidebar ul li a:hover {
  color: #fff;
}
#sidebar ul li.active > a {
  background: transparent;
  color: #fff;
}
@media (max-width: 991.98px) {
  #sidebar {
    margin-left: -250px;
  }
  #sidebar.active {
    margin-left: 0;
  }
}
#sidebar .custom-menu {
  display: inline-block;
  position: sticky;
  top: 15px;
  left: 220px;
  margin-right: -20px;
  -webkit-transition: 0.3s;
  -o-transition: 0.3s;
  transition: 0.3s;
}
@media (prefers-reduced-motion: reduce) {
  #sidebar .custom-menu {
    -webkit-transition: none;
    -o-transition: none;
    transition: none;
  }
}
#sidebar .custom-menu .btn {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  position: relative;
}
#sidebar .custom-menu .btn i {
  margin-right: -30px;
  font-size: 14px;
}
#sidebar .custom-menu .btn.btn-primary {
  background: transparent;
  border-color: transparent;
}
#sidebar .custom-menu .btn.btn-primary:after {
  z-index: -1;
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  content: "";
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
  background: #3445b4;
  border-radius: 10px;
}
#sidebar .custom-menu .btn.btn-primary:hover,
#sidebar .custom-menu .btn.btn-primary:focus {
  background: transparent !important;
  border-color: transparent !important;
}

a[data-toggle="collapse"] {
  position: relative;
}

.dropdown-toggle::after {
  display: block;
  position: absolute;
  top: 50%;
  right: 0;
  -webkit-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  transform: translateY(-50%);
}

@media (max-width: 991.98px) {
  #sidebarCollapse span {
    display: none;
  }
}

#content {
  width: 100%;
  padding: 0;
  min-height: 100vh;
  -webkit-transition: all 0.3s;
  -o-transition: all 0.3s;
  transition: all 0.3s;
}

.btn.btn-primary {
  background: #3445b4;
  border-color: #3445b4;
}
.btn.btn-primary:hover,
.btn.btn-primary:focus {
  background: #3445b4 !important;
  border-color: #3445b4 !important;
}

.footer p {
  color: rgba(255, 255, 255, 0.5);
}

.footer button{
  color:white;
  background-color: #5262c8;
}

.footer button:hover{
  background-color: #44bef1;
}

.form-control {
  height: 40px !important;
  background: #fff;
  color: #000;
  font-size: 13px;
  border-radius: 4px;
  -webkit-box-shadow: none !important;
  box-shadow: none !important;
  border: transparent;
}
.form-control:focus,
.form-control:active {
  border-color: #000;
}
.form-control::-webkit-input-placeholder {
  /* Chrome/Opera/Safari */
  color: rgba(255, 255, 255, 0.5);
}
.form-control::-moz-placeholder {
  /* Firefox 19+ */
  color: rgba(255, 255, 255, 0.5);
}
.form-control:-ms-input-placeholder {
  /* IE 10+ */
  color: rgba(255, 255, 255, 0.5);
}
.form-control:-moz-placeholder {
  /* Firefox 18- */
  color: rgba(255, 255, 255, 0.5);
}

.subscribe-form .form-control {
  background: #5262c8;
  color: white;
}

a {
  text-decoration: none;
  transition: 0.3s;
}

a:hover {
  color: white;
}

button:hover,
button:focus {
  text-decoration: none !important;
  outline: none !important;
  -webkit-box-shadow: none !important;
  box-shadow: none !important;
}
</style>