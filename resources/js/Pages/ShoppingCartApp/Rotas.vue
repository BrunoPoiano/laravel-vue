<template>
  <div class="row ">
    <div class="col">
        <a
          :href="route('shoppingcart.layout.criariventario')"
          class="btn btn-success "
        >
          Criar Inventario
        </a>
        |
        <a
          :href="route('shoppingcart.layout.index')"
          class="btn btn-success "
        >
          Shopping 
                  </a>
        |
          <a
          :href="route('shoppingcart.layout.shoppingcart')"
          class="btn btn-success "
        >
          Shopping Cart
        </a>
    </div>
  </div>

  
</template>
