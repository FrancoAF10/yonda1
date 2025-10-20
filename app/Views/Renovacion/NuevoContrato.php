<?= $header ?>


<div class="pc-container my-2">
  <div class="pc-content">
    <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
    <?php endif; ?>
    <h4>Nuevo Contrato </h4>

    <form method="POST" action="<?=base_url("renovacion/nuevocontrato")?>">
    <div class="row">
        <div class="col-md-7 mb-3">
          <div class="card h-100">
            <div class="card-body">
               <div class="row mb-3">
                <input type="hidden" name="idpersona" id="idpersona" value="<?=$persona['idpersona']?>" required>
                <div class="col-md-12 mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control"  value="<?=$persona['apepaterno']?> <?=$persona['apematerno']?> <?=$persona['nombres']?>">
                        <label for="personaContrato">Personal</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" id="departamentoContrato" name="departamentoContrato" required>
                            <option value="">Seleccionar Departamento</option>
                            <?php foreach($departamentoSucursales as $departamento): ?>
                            <option value="<?=$departamento['iddepartamento']?>"
                                <?= ($iddepartamento == $departamento['iddepartamento']) ? 'selected' : '' ?>>
                                <?=$departamento['departamento']?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                        <label for="departamentoContrato">Departamento</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" id="provinciaContrato" name="provinciaContrato" required>
                            <option value="">Seleccionar Provincia</option>
                            <?php foreach($provincias as $prov): ?>
                                <option value="<?=$prov['idprovincia']?>"
                                    <?= ($idprovincia == $prov['idprovincia']) ? 'selected' : '' ?>>
                                    <?=$prov['provincia']?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="provinciaContrato">Provincia</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" id="distritoContrato" name="distritoContrato" required>
                            <option value="">Seleccionar Distrito</option>
                            <?php foreach($distritos as $dis): ?>
                                <option value="<?=$dis['iddistrito']?>"
                                    <?= ($iddistrito == $dis['iddistrito']) ? 'selected' : '' ?>>
                                    <?=$dis['distrito']?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="distritoContrato">Distrito</label>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select" id="sucursalContrato" name="idsucursal" required>
                            <option value="">Seleccionar Sucursal</option>
                            <?php foreach($sucursales as $suc): ?>
                                <option value="<?=$suc['idsucursal']?>"
                                    <?= ($idsucursal == $suc['idsucursal']) ? 'selected' : '' ?>>
                                    <?=$suc['sucursal']?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="sucursalContrato">Sucursal</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select" id="areaContrato" name="idarea" required>
                            <option value="">Seleccionar Área</option>
                            <?php foreach($areas as $ar): ?>
                                <option value="<?=$ar['idarea']?>"
                                    <?= ($idarea == $ar['idarea']) ? 'selected' : '' ?>>
                                    <?=$ar['area']?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="areaContrato">Área</label>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="form-floating">
                        <select class="form-select" id="cargoContrato" name="idcargo" required>
                            <option value="">Seleccionar Cargo</option>
                            <?php foreach($cargos as $car): ?>
                                <option value="<?=$car['idcargo']?>"
                                    <?= ($idcargo == $car['idcargo']) ? 'selected' : '' ?>>
                                    <?=$car['cargo']?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="cargoContrato">Cargo</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="date" class="form-control" id="fechainicio" name="fechainicio" value="<?= $fechainicio ?? '' ?>" required>
                        <label for="fechainicio">Fecha de Inicio del Contrato</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="date" class="form-control" id="fechafin" name="fechafin" value="<?= $fechafin ?? '' ?>" required>
                        <label for="fechafin">Fecha de Fin del Contrato</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="number" class="form-control" id="sueldobase" name="sueldobase" value="<?= $sueldobase ?? '' ?>" required>
                        <label for="sueldobase">Sueldo Base del Trabajador</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="number" class="form-control" id="toleranciadiaria" name="toleranciadiaria" value="<?= $toleranciadiaria ?? '' ?>" required>
                        <label for="toleranciadiaria">Tolerancia Diaria (min)</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="number" class="form-control" id="toleranciamensual" name="toleranciamensual" value="<?= $toleranciamensual ?? '' ?>" required>
                        <label for="toleranciamensual">Tolerancia Mensual (min)</label>
                    </div>
                </div>
            </div>
          </div>
          <div class="card-footer text-end">
        <a href="<?=base_url('/Renovacion/ContratosVencidos')?>" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Registrar</button>
          </div>
          </div>
      </div>
        
</form>

        <div class="col-md-5 mb-3">
          <div class="card h-100">
            <div class="card-header">Historial de Contratos</div>
                <div class="card-body" id="historial-contratos">
                    <div>
                        <?php if (!empty($vencidos)): ?>
                            <?php foreach ($vencidos as $c): ?>
                            <div class="border-bottom py-2">
                                <b><?= $c['cargo'] ?></b> <?= $c['area'] ?> - <?=$c['sucursal'] ?><br>
                                <?= date("d-m-Y", strtotime($c['fechainicio'])) ?> → <?= date("d-m-Y", strtotime($c['fechafin'])) ?> | S/. <?=$c['sueldobase'] ?>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-danger">No se encontraron contratos vencidos</p>
                        <?php endif; ?>
                        </div>
                </div>
          </div>
        </div>
      </div>
  </div> <!-- ./pc-content -->
</div> <!-- ./pc-container -->

<script>
document.addEventListener("DOMContentLoaded", () => {
  const historial = document.querySelector("#historial-contratos");
  const departamentoSucursal=document.querySelector("#departamentoContrato");
  const provinciaSucursal=document.querySelector("#provinciaContrato");
  const distritoSucursal=document.querySelector("#distritoContrato");
  const sucursal=document.querySelector("#sucursalContrato");
  const areaSucursal=document.querySelector("#areaContrato");
  const cargoSucursal=document.querySelector("#cargoContrato");

    departamentoSucursal.addEventListener('change',async()=>{
        const iddepartamentoSucursal=departamentoSucursal.value;

        if(!iddepartamentoSucursal){
            provinciaSucursal.innerHTML=`<option>Seleccione</option>`;
            return;
        }

        try{
            const response=await fetch(`<?=base_url()?>/provincias/${iddepartamentoSucursal}`,{
                method:'GET',
                headers:{'Content-Type':'application/json'}
            })

            if(!response.ok){
                throw new Error('Error en la consulta del servidor');
            }
            const data=await response.json()
            if(data.length){
                provinciaSucursal.innerHTML=`<option>Seleccione Provincia</option>`
                data.forEach(provincS => {
                    provinciaSucursal.innerHTML+=`<option value='${provincS.idprovincia}'>${provincS.provincia}</option>`
                });
            }
        }catch(error){
            console.error(error);
        }
    })//traemos las provincias 

    provinciaSucursal.addEventListener('change',async()=>{
        const idprovinciaSucursal=provinciaSucursal.value;
        if(!idprovinciaSucursal){
            distritoSucursal.innerHTML=`<option>Seleccione</option>`;
            return;
        }
        try{
            const response=await fetch(`<?=base_url()?>/distritos/${idprovinciaSucursal}`,{
                method:'GET',
                headers:{'Content-Type':'application/json'}
            })

            if(!response.ok){
                throw new Error("Error en la respuesta del servidor");
            }
            const data= await response.json()
            if(data.length){
                distritoSucursal.innerHTML=`<option>Seleccione Distrito</option>`
                data.forEach(distS => {
                    distritoSucursal.innerHTML+=`<option value='${distS.iddistrito}'>${distS.distrito}</option>`
                });
            }
        }catch(error){
            console.error(error);
        }
    })

    distritoSucursal.addEventListener('change',async()=>{
        const iddistritoSucursal=distritoSucursal.value;
        if(!iddistritoSucursal){
            sucursal.innerHTML=`<option>Seleccione</option>`;
            return;
        }

        try {
            const response=await fetch(`<?=base_url()?>/sucursales/${iddistritoSucursal}`,{
                method:'GET',
                headers:{'Content-Type':'application/json'}
            })
            if(!response.ok){
                throw new Error("Error en la respuesta del Servidor");
            }

            const data=await response.json();
            if(data.length){
                sucursal.innerHTML=`<option>Seleccione Sucursal</option>`
                data.forEach(suc => {
                    sucursal.innerHTML+=`<option value='${suc.idsucursal}'>${suc.sucursal}</option>`
                });
            }
        } catch (error) {
            console.error(error);
        }
    })

    sucursal.addEventListener('change',async()=>{
        const idsucursal=sucursal.value;
        if(!idsucursal){
            areaSucursal.innerHTML=`<option>Seleccione</option>`;
            return;
        }

        try {
            const response=await fetch(`<?=base_url()?>/areas/${idsucursal}`,{
                method:'GET',
                headers:{'Content-Type':'application/json'}
            })
            if(!response.ok){
                throw new Error("Error en la respuesta del Servidor");
            }

            const data=await response.json();
            if(data.length){
                areaSucursal.innerHTML=`<option>Seleccione Área</option>`
                data.forEach(ar => {
                    areaSucursal.innerHTML+=`<option value='${ar.idarea}'>${ar.area}</option>`
                });
            }
        } catch (error) {
            console.error(error);
        }
    })

    areaSucursal.addEventListener('change',async()=>{
        const idareaSucursal=areaSucursal.value;
        if(!idareaSucursal){
            areaSucursal.innerHTML=`<option>Seleccione</option>`;
            return;
        }

        try {
            const response=await fetch(`<?=base_url()?>/cargos/${idareaSucursal}`,{
                method:'GET',
                headers:{'Content-Type':'application/json'}
            })
            if(!response.ok){
                throw new Error("Error en la respuesta del Servidor");
            }

            const data=await response.json();
            if(data.length){
                cargoSucursal.innerHTML=`<option>Seleccione Cargo</option>`
                data.forEach(car => {
                    cargoSucursal.innerHTML+=`<option value='${car.idcargo}'>${car.cargo}</option>`
                });
            }
        } catch (error) {
            console.error(error);
        }
    })
       

  
}   );
</script>

<?= $footer ?>