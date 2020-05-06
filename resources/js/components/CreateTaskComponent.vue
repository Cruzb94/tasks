<template>
    <div class="container">
        <div class="row justify-content-center"> 
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h2>Registrar Tarea</h2></div>
                    <div class="card-body">
                       <form @submit.prevent="addTask" action="" enctype="multipart/form-data">
                           <div class="form-group">
                                <label for="name">Nombre:</label>
                                <input type="text" id="name" v-model="task.name" class="form-control">
                           </div>
                           <div class="form-group">
                                <label for="stock">Descripción:</label>
                                <textarea name="" v-model="task.description" id="description" cols="30" rows="10" class="form-control"></textarea>
                           </div>
                           <div class="form-group">
                                <label for="stock">Fecha Inicio:</label>
                                <input type="date" id="fecha_ini" v-model="task.fecha_ini" class="form-control">
                           </div>
                           <div class="form-group">
                                <label for="stock">Fecha Fin:</label>
                                <input type="date" id="fecha_fin" v-model="task.fecha_fin" class="form-control">
                           </div>
                           <button type="submit" class="btn btn-primary">Guardar</button>
                       </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                imagenMiniatura: '../admin/img/test.png',
                url: '',
                task: {
                    name: '',
                    description: '',
                    fecha_ini: '',
                    fecha_fin: '',
                },
            }
        },
        methods: {
            addTask(){
                
            let formData = new FormData();

               if(this.task.name == '' || this.task.description == '' || this.task.fecha_ini == '' || this.task.fecha_fin == ''){
                    alert('Debe rellenar todos los campos');
                }else{
                    formData.append('name', this.task.name);
                    formData.append('description', this.task.description);
                    formData.append('fecha_ini', this.task.fecha_ini);
                    formData.append('fecha_fin', this.task.fecha_fin);
                
                    axios.post('../tasks', formData)
                        .then(response => {
                            console.log(response.data);
                            if(response.data.status == 'error'){
                                alert(response.data.msg);
                                this.task.name = '';
                                this.task.description = '';
                                this.task.fecha_ini = '';
                                this.task.fecha_fin = '';
                            }

                            if(response.data.status == 'success'){
                                alert(response.data.msg);
                                this.task.name = '';
                                this.task.description = '';
                                this.task.fecha_ini = '';
                                this.task.fecha_fin = '';
                            }
                            
                    });
                }
            }

        },
    }
</script>

