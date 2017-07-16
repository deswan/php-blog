<template>
<div id="category" class="container-fluid">
  <div class="row">
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

          <form class="navbar-form navbar-left">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Search">
            </div>
          </form>

          <form class="navbar-form navbar-right">
            <div class="form-group">
              <input type="text" class="form-control">
            </div>
            <button type="submit" class="btn btn-default">提交</button>
          </form>

          <ul class="nav navbar-nav navbar-right">
            <li><i class="logo fa fa-plus" aria-hidden="true"></i></li>
          </ul>
        </div>
      </div>
    </nav>
    <section class="body">
      <div class="panel panel-default tag-panel">
        <!-- Default panel contents -->
        <div class="panel-heading">code</div>
        <div class="panel-body">
          <p>...</p>
        </div>

        <!-- List group -->
        <ul class="list-group">
          <li class="list-group-item">Cras justo odio</li>
          <li class="list-group-item">Dapibus ac facilisis in</li>
          <li class="list-group-item">Morbi leo risus</li>
          <li class="list-group-item">Porta ac consectetur ac</li>
          <li class="list-group-item">Vestibulum at eros</li>
          <li class="list-group-item">Cras justo odio</li>
          <li class="list-group-item">Dapibus ac facilisis in</li>
          <li class="list-group-item">Morbi leo risus</li>
          <li class="list-group-item">Porta ac consectetur ac</li>
          <li class="list-group-item">Vestibulum at eros</li>
          <li class="list-group-item">Cras justo odio</li>
          <li class="list-group-item">Dapibus ac facilisis in</li>
          <li class="list-group-item">Morbi leo risus</li>
          <li class="list-group-item">Porta ac consectetur ac</li>
          <li class="list-group-item">Vestibulum at eros</li>
          <li class="list-group-item">Cras justo odio</li>
          <li class="list-group-item">Dapibus ac facilisis in</li>
          <li class="list-group-item">Morbi leo risus</li>
          <li class="list-group-item">Porta ac consectetur ac</li>
          <li class="list-group-item">Vestibulum at eros</li>
          <li class="list-group-item">Cras justo odio</li>
          <li class="list-group-item">Dapibus ac facilisis in</li>
          <li class="list-group-item">Morbi leo risus</li>
          <li class="list-group-item">Porta ac consectetur ac</li>
          <li class="list-group-item">Vestibulum at eros</li>
        </ul>
      </div>
      <div class="panel panel-default tag-panel">
        <!-- Default panel contents -->
        <div class="panel-heading">essay</div>
        <div class="panel-body">
          <p>...</p>
        </div>

        <!-- List group -->
        <ul class="list-group">
          <li class="list-group-item">Cras justo odio</li>
          <li class="list-group-item">Dapibus ac facilisis in</li>
          <li class="list-group-item">Morbi leo risus</li>
          <li class="list-group-item">Porta ac consectetur ac</li>
          <li class="list-group-item">Vestibulum at eros</li>
        </ul>
      </div>
    </section>
  </div>
</div>
</template>
<script>
export default {
  data() {
    return {
      coding: [{
        rename: false,
        id: 1,
        name: 'pqhp'
      }],
      essay: [{
        rename: false,
        id: 1,
        name: 'qwe'
      }],
      catMaxLength: 20
    }
  },
  beforeCreate() {
    $.get("/admin/categories/data", (data) => {
      console.log(data);
      for (let i = 0; i < data.coding.length; i++) {
        data.coding[i].rename = false
      }
      for (let i = 0; i < data.essay.length; i++) {
        data.essay[i].rename = false
      }
      this.coding = data.coding;
      this.essay = data.essay;
    });
  },
  methods: {
    drawRename(item) {
      item.rename = item.rename ? false : true;
    },
    toSubmit(e) {
      var dom = $(e.target).find('input[name=name]');
      if (dom.val().length > this.catMaxLength || dom.val().length === 0) {
        console.log('submit false');
        return false;
      } else {
        var that = this;
        $.ajax({
          url: '/admin/categories/validateName',
          data: {
            name: dom.val()
          },
          complete(xhr) {
            if (xhr.status === 200) {
              e.target.submit();
            } else if (xhr.status === 422) {
              alert('该名称已被使用')
            }
          }
        })

      }
    }

  }
}
</script>
<style scoped lang="scss">
.tag-panel {
    width: 50%;
    float: left;
    margin-top: 70px;
}
.navbar-fixed-top{
    padding-left: 100px;
}
.logo {
    font-size: 30px;
    line-height: 50px;
}
</style>
