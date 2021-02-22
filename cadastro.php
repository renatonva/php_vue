<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>
<body>
<div class="container" id="App">
   <br />
   <h3 align="center">Cadastro de Usuários ao sistema</h3>
   <br />
   <div class="panel panel-default">
    <div class="panel-heading">
     <div class="row">
      <div class="col-md-6">
       <h3 class="panel-title">Listar Usuários</h3>
      </div>
      <div class="col-md-6" align="right">
       <input type="button" class="btn btn-success btn-xs" @click="openModel" value="Inserir" />
      </div>
     </div>
    </div>
    <div class="panel-body">
     <div class="table-responsive">
      <table class="table table-bordered table-striped">
       <tr>
        <th>Primeiro Nome</th>
        <th>Último Nome</th>
        <th>Editar</th>
        <th>Excluir</th>
       </tr>
       <tr v-for="row in allData">
        <td>{{ row.first_name }}</td>
        <td>{{ row.last_name }}</td>
        <td><button type="button" name="edit" class="btn btn-primary btn-xs edit" @click="fetchData(row.id)">Edit</button></td>
        <td><button type="button" name="delete" class="btn btn-danger btn-xs delete" @click="deleteData(row.id)">Delete</button></td>
       </tr>
      </table>
     </div>
    </div>
   </div>
   <div v-if="myModal">
    <transition name="model">
     <div class="modal-mask">
      <div class="modal-wrapper">
       <div class="modal-dialog">
        <div class="modal-content">
         <div class="modal-header">
          <button type="button" class="close" @click="myModal=false"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">{{ dynamicTitle }}</h4>
         </div>
         <div class="modal-body">
          <div class="form-group">
           <label>Enter First Name</label>
           <input type="text" class="form-control" v-model="first_name" />
          </div>
          <div class="form-group">
           <label>Enter Last Name</label>
           <input type="text" class="form-control" v-model="last_name" />
          </div>
          <div class="form-group">
           <label>Senha</label>
           <input type="password" class="form-control" v-model="password" />
          </div>
          <br />
          <div align="center">
           <input type="hidden" v-model="hiddenId" />
           <input type="button" class="btn btn-success btn-xs" v-model="actionButton" @click="submitData" />
          </div>
         </div>
        </div>
       </div>
      </div>
     </div>
    </transition>
   </div>
</div>

<script>

var vm = new Vue({
 el:'#App',
 data:{
  allData:'',
  myModal:false,
  actionButton:'Insert',
  dynamicTitle:'Add Data',
  hiddenId:''
 },
 methods:{
  fetchAllData:function(){
   axios.post('action.php', {
    action:'fetchall'
   }).then(function(response){
    vm.allData = response.data;
   });
  },
  openModel:function(){
   vm.first_name = '';
   vm.last_name = '';
   vm.password = '';
   vm.actionButton = "Insert";
   vm.dynamicTitle = "Add Data";
   vm.myModal = true;
  },
  submitData:function(){
   if(vm.first_name != '' && vm.password != '')
   {
    if(vm.actionButton == 'Insert')
    {
     axios.post('action.php', {
      action:'insert',
      firstName:vm.first_name, 
      lastName:vm.last_name,
      password:vm.password,
     }).then(function(response){
      vm.myModal = false;
      vm.fetchAllData();
      vm.first_name = '';
      vm.last_name = '';
      vm.password = '';
      alert(response.data.message);
     });
    }
    if(vm.actionButton == 'Update')
    {
     axios.post('action.php', {
      action:'update',
      firstName : vm.first_name,
      lastName : vm.last_name,
      password : vm.password,
      hiddenId : vm.hiddenId
     }).then(function(response){
      vm.myModal = false;
      vm.fetchAllData();
      vm.first_name = '';
      vm.last_name = '';
      vm.password = '';
      vm.hiddenId = '';
      alert(response.data.message);
     });
    }
   }
   else
   {
    alert("Fill All Field");
   }
  },
  fetchData:function(id){
   axios.post('action.php', {
    action:'fetchSingle',
    id:id
   }).then(function(response){
    vm.first_name = response.data.first_name;
    vm.last_name = response.data.last_name;
    vm.hiddenId = response.data.id;
    vm.password = response.data.password;
    vm.myModal = true;
    vm.actionButton = 'Update';
    vm.dynamicTitle = 'Edit Data';
   });
  },
  deleteData:function(id){
   if(confirm("Você gostaria de excluir o usuário"))
   {
    axios.post('action.php', {
     action:'delete',
     id:id
    }).then(function(response){
     vm.fetchAllData();
     alert(response.data.message);
    });
   }
  }
 },
 created:function(){
  this.fetchAllData();
 }
});

</script>

</body>
</html>