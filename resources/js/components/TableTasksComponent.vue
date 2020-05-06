<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><h2>Listado de Tareas</h2></div>

                    <div class="card-body">
                      <table class="table" id="table_tasks">
                        <thead>
                          <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Estatus</th>
                            <th scope="col">Fecha Inicio</th>
                            <th scope="col">Fecha Fin</th>
                            <th scope="col">Opciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="task in tasks">
                            <td>{{ task.name }}</td>
                            <td>{{ task.description }}</td>
                            <td>{{ task.task_status.status }}</td>
                            <td>{{ task.reminder_date }}</td>
                            <td>{{ task.expiration_date }}</td>
                            <td><a @click="deleteTask(task.id)"> <span class="fa fa-fw fa-trash"></span> </a> 
                            <a @click="editTask(task.id)"> <span class="fa fa-edit" data-toggle="modal" data-target="#modal-default"></span> </a> </td>
                          </tr>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-default" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Editar Tarea</h4>
              </div>
              <div class="modal-body">
                 <form @submit.prevent="updateTask" action="">
                   <div class="form-group">
                        <label for="name">Nombre:</label>
                        <input type="text" id="name" v-model="task.name" class="form-control">
                   </div>
                   <div class="form-group">
                        <label for="stock">Descripción:</label>
                        <textarea name="" v-model="task.description" id="description" cols="30" rows="5" class="form-control"></textarea>
                   </div>
                   <div class="form-group">
                        <label for="stock">Fecha Inicio:</label>
                        <input type="date" id="fecha_ini" v-model="task.fecha_ini" class="form-control">
                   </div>
                   <div class="form-group">
                        <label for="stock">Fecha Fin:</label>
                        <input type="date" id="fecha_fin" v-model="task.fecha_fin" class="form-control">
                   </div>
                   <div class="form-group">
                        <label for="stock">Estatus:</label>
                        <select name="" id="status_task" v-model="task.status" class="form-control">
                            <option value="pending">Pendiente</option>
                            <option value="finished">Finalizada</option>
                        </select>
                   </div>
                   <button type="submit" class="btn btn-primary">Guardar</button>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" id="cerrar" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

        
    </div>
</template>

<script>
    import datatables from 'datatables'
    export default {
        mounted(){
            this.getTasks();
        },
        data: function() { 
            return {
                tasks: [],
                task: {
                    id: '',
                    name: '',
                    description: '',
                    status: '',
                    fecha_ini: '',
                    fecha_fin: '',
                },
            }
        },
        methods: {
            getTasks(){
                axios.get('./getTasks')
                    .then(response => {
                        this.tasks = response.data;
                        // console.log(this.tasks)
                        this.tableTasks();
                    });

            },
            tableTasks(){
                $(document).ready( function () {
                    $('#table_tasks').DataTable();
                });
            },
            deleteTask(task){
                let result = window.confirm('¿Desea eliminar esta tarea?');

                if(result){
                    axios.get('./deleteTask/'+task)
                    .then(response => {
                       if(response.data == 1){
                        alert('Tarea eliminada');
                       }else{
                        alert('Error al eliminar');
                       }
                       this.getTasks();
                    });
                }else{
                    return false;
                }
                
            },
            updateTask(){

                let formData = new FormData();

                if(this.task.name == '' || this.task.description == '' || this.task.fecha_ini == '' || this.task.fecha_fin == ''){
                    alert('Debe rellenar todos los campos');
                }else{
                    formData.append('id', this.task.id);
                    formData.append('name', this.task.name);
                    formData.append('description', this.task.description);
                    formData.append('status', this.task.status);
                    formData.append('fecha_ini', this.task.fecha_ini);
                    formData.append('fecha_fin', this.task.fecha_fin);
                
                    // console.log(formData);
                    axios.post('../updateTask', formData)
                        .then(response => {
                            console.log(response.data);
                            if(response.data.status == 'error'){
                                alert(response.data.msg);
                                this.task.id = '';
                                this.task.name = '';
                                this.task.description = '';
                                this.task.status = '';
                                this.task.fecha_ini = '';
                                this.task.fecha_fin = '';
                            }

                            if(response.data.status == 'success'){
                                alert(response.data.msg);
                                this.task.id = '';
                                this.task.name = '';
                                this.task.description = '';
                                this.task.status = '';
                                this.task.fecha_ini = '';
                                this.task.fecha_fin = '';
                                this.getTasks();
                                document.getElementById('cerrar').click();
                            }
                            
                    });
                    
                }
            },
            editTask(id_task){
                console.log(id_task);

                axios.get('./getTask/'+id_task)
                    
                .then(response => {
                    console.log(response);
                    this.task.id = response.data.id;
                    this.task.name = response.data.name;
                    this.task.description = response.data.description;
                    this.task.status = response.data.task_status.status;
                    this.task.fecha_ini = response.data.reminder_date;
                    this.task.fecha_fin = response.data.expiration_date;
                    document.getElementById('name').value = response.data.name;
                    document.getElementById('description').value  = response.data.description;
                    document.getElementById('fecha_ini').value = response.data.reminder_date;
                    document.getElementById('fecha_fin').value = response.data.expiration_date;
                    document.getElementById('status_task').value = response.data.task_status.status;
                });
            },
        },
    }
</script>
