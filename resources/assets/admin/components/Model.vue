<template>
  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" style="z-index:11111;top:30%;">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <slot></slot>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" @click="close">关闭</button>
          <button type="button" class="btn btn-primary" @click="confirm" v-if="confirmBtnText">{{confirmBtnText}}</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props:{
    confirmArg:{},
    confirmBtnText:{
      type:String,
      default:''
    },
    showModal:{
      default:false
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
      this.$emit('confirm',this.confirmArg);
    },
    close(){
      this.$emit('close',this.confirmArg);
    },
    show(){
      this.modal.modal('show');
    },
    hide(){
      this.modal.modal('hide');
    }
  },
  watch:{
    showModal(to){
      if(to){
        this.show();
      }else{
        this.hide();
      }
    }
  }
}
</script>
<style scoped lang="scss">
</style>
