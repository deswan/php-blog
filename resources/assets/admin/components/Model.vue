<template>
  <div class="modal" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" style="z-index:11111;top:30%;">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <slot></slot>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal" @click="confirm" v-if="confirmBtnText">{{confirmBtnText}}</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props:{
    arg:{
      default:null
    },
    confirmBtnText:{
      type:String,
      default:''
    }
  },
  data(){
    return{
      modal:null
    }
  },
  mounted(){
    this.modal = window.$('#modal');
  },
  methods:{
    confirm(){
      this.$emit('confirm',this.arg);
    },
    show(){
      this.modal.modal('show');
    },
    hide(){
      this.modal.modal('hide');
    }
  }
}
</script>
<style scoped lang="scss">
</style>
