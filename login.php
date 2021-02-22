<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <title>Acesso ao Sistema</title>
</head>
<body>
    <div id="App" align="center">
        <div class="modal-wrapper">
         
            <div class="form-group">
            <label>Enter First Name</label>
            <input type="text" class="form-control" v-model="first_name" />
            </div>
            <div class="form-group">
            <label>Senha</label>
            <input type="password" class="form-control" v-model="password" />
            </div>
            {{ situacao }}
            <button type="submit" class="btn btn-primary" @click="submitData">Enviar</button>
          
        </div>
    </div>
    <script>
    const vm = new Vue({
        el:"#App",
        data:{
            actionbutton: 'Login',
            allData: '',
           first_name: '',
           password: '',
           situacao: '',

        },
        methods:{
            submitData:function(){
              
                if(vm.first_name != '' && vm.password != ''){
                    axios.post('action.php', {
                    action:'login',
                    firstName : vm.first_name,
                    password : vm.password,
                    
                }).then(function(response){
                    vm.allData = response.data;
                    vm.resposta = response.data.resposta;
                  
                    if (response.data.status === 200 && response.data.id !== '') {
                        this.$session.start()
                        this.$session.set('jwt', response.data.id)
                        Vue.http.headers.common['Authorization'] = 'Bearer ' + response.data.id
                        this.$router.push('/panel/search')
                    }else{
                        vm.situacao = 'Usuário ou senha inválidos';
                    }
                    
                   
                });
                }
            }
        }
    })
    </script>
</body>
</html>