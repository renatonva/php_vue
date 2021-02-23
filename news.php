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
    <div class="container" id="Noticias">
        <br />
        <h3 align="center">Cadastro de Publicações</h3>
        <br />  {{ mensagem }}
        <div class="panel panel-default">
                <div class="form-group">
                <label>Título</label>
                <input type="text" class="form-control" v-model="title" />
                </div>
                <div class="form-group">
                <label>Categoria</label>
                <select class="form-control" v-model="category" />
                        <option value="1">Viagem</option>
                </select>
                </div>
                <div class="form-group">
                <label>Texto</label>
                <textarea class="form-control" v-model="description" >Enter text here...</textarea>
                
                </div>
                <br />
                <div align="center">
                <input type="hidden" v-model="hiddenId" />
                <input type="button" class="btn btn-success btn-xs" v-model="actionButton" @click="submitData" /> 
                </div>         
        </div>
    </div>
    <script>
        const vm = new Vue({
            el:"#Noticias",
            data:{
                title: '',
                category:'',
                description:'',
                actionButton: 'Insert',
                hiddenId: '',
                mensagem: ''
            },
            methods:{
                submitData:function(){
                   
                    if(vm.title != '' && vm.description != ''){
                        
                        if(vm.actionButton == 'Insert'){
                            axios.post('action.php',{
                                action:'Insere_publicacao',
                                title:vm.title,
                                category:vm.category,
                                description:vm.description,
                                date_insert: '',
                                status: 'A',

                            }).then(function(response){
                                vm.mensagem = response.data.message;
                                vm.category = '';
                                vm.title = '';
                                vm.description = '';
                            })
                        }
                    }else{
                        vm.mensagem = "Titulo ou Descrição não foram inseridos";
                    }
                  
                }
            }
        });
    </script>
</body>
</html>
