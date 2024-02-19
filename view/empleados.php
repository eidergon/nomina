<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../');
    exit();
}

$perfil = $_SESSION["perfil"];
$nombre = $_SESSION["nombre"];
?>

<form id="empleados" enctype="multipart/form-data" class="form">
    <h1 class="empleados">Empleados</h1>

    <input class="input" id="nombre" name="nombre" type="text" placeholder="Nombre" autocomplete="off" required>

    <select name="tipo_documento" id="tipo_documento" class="input" required>
        <option value="">Tipo De Documento</option>
        <option value="CC">Cedula De Ciudadania</option>
        <option value="CE">Cedula De Extranjeria</option>
        <option value="TI">Tarjeta De Identidad</option>
        <option value="PPT">Pasaporte</option>
        <option value="PEP">Permiso de Permanencia</option>
    </select>

    <input class="input" id="cc_user" name="cc_user" type="text" placeholder="N° De Identificacion" autocomplete="off" required>

    <input class="input" id="contraseña" name="contraseña" type="text" placeholder="Contraseña" autocomplete="off" required>

    <label for="fecha">Fecha de Ingreso</label>
    <input class="input" id="fecha" name="fecha" type="date" autocomplete="off" required>

    <select class="input" name="hora_contrato" id="hora_contrato" required>
        <option value="">Horas de contratación</option>
        <option value="4">4 Horas</option>
        <option value="6">6 Horas</option>
        <option value="8">8 Horas</option>
    </select>

    <input class="input" list="jefe" name="jefe" type="text" placeholder="Jefe Inmediato" required>
    <datalist id="jefe">
        <option value="ALLISON CASTRO">ALLISON CASTRO</option>
        <option value="ANDREA ALVARADO">ANDREA ALVARADO</option>
        <option value="ANGIE PEREZ">ANGIE PEREZ</option>
        <option value="BRYAN QUINTERO">BRYAN QUINTERO</option>
        <option value="CAMILA BORDA">CAMILA BORDA</option>
        <option value="CAMILO AGUILAR">CAMILO AGUILAR</option>
        <option value="DALLANA RICO">DALLANA RICO</option>
        <option value="DAVID MUÑOZ">DAVID MUÑOZ</option>
        <option value="DAYNY PINO">DAYNY PINO</option>
        <option value="EDGAR SANCHEZ">EDGAR SANCHEZ</option>
        <option value="JHOSERTH PINO">JHOSERTH PINO</option>
        <option value="JOHN TORRES">JOHN TORRES</option>
        <option value="JOSIAS RESTREPO">JOSIAS RESTREPO</option>
        <option value="JUAN GARZON">JUAN GARZON</option>
        <option value="KAROL VIRGUEZ">KAROL VIRGUEZ</option>
        <option value="KATY ANAYA">KATY ANAYA</option>
        <option value="LISBET SANCHEZ">LISBET SANCHEZ</option>
        <option value="LYSBEY VALENCIA">LYSBEY VALENCIA</option>
        <option value="MARIA RUIZ">MARIA RUIZ</option>
        <option value="MARTIN CHILATRA">MARTIN CHILATRA</option>
        <option value="NICOL GALINDO">NICOL GALINDO</option>
        <option value="PABLO CASTELLANOS">PABLO CASTELLANOS</option>
        <option value="PATRICIA RINCON">PATRICIA RINCON</option>
        <option value="ROBINSON CASTAÑO">ROBINSON CASTAÑO</option>
        <option value="SANTIAGO VALENCIA">SANTIAGO VALENCIA</option>
        <option value="SEBASTIAN AYURE">SEBASTIAN AYURE</option>
        <option value="VIVIANA CRUZ">VIVIANA CRUZ</option>
    </datalist>

    <input class="input" id="campañas" name="campaña" list="campaña" placeholder="Campaña" required>
    <datalist id="campaña">
        <option value="ADMINISTRATIVO">ADMINISTRATIVO</option>
        <option value="APRENDIZ">APRENDIZ</option>
        <option value="B2B2C">B2B2C</option>
        <option value="BACK OFFICE">BACK OFFICE</option>
        <option value="COMUNIDAD">COMUNIDAD</option>
        <option value="FORMACION Y CALIDAD">FORMACION Y CALIDAD</option>
        <option value="GERENCIA">GERENCIA</option>
        <option value="HOGAR">HOGAR</option>
        <option value="MOVIL">MOVIL</option>
        <option value="STAFF B2B2C">STAFF B2B2C</option>
        <option value="STAFF COMUNIDADES">STAFF COMUNIDADES</option>
        <option value="STAFF IT">STAFF IT</option>
        <option value="STAFF P&F">STAFF P&F</option>
        <option value="STAFF TMK">STAFF TMK</option>
        <option value="STAFF TYT">STAFF TYT</option>
        <option value="STAFF USUARIOS Y SSFF">STAFF USUARIOS Y SSFF</option>
        <option value="STAFF W&D">STAFF W&D</option>
        <option value="TYT">TYT</option>
        <option value="WORKFORCE">WORKFORCE</option>
        <option value="STAFF DATA ANALYSIS">STAFF DATA ANALYSIS</option>
    </datalist>

    <input class="input" name="sub_campaña" list="sub_campaña" id="sub_campañas" placeholder="Sub Campaña" required>
    <datalist id="sub_campaña">
        <option value="B2B2C">B2B2C</option>
        <option value="COMUNIDAD">COMUNIDAD</option>
        <option value="DEDICADAS">DEDICADAS</option>
        <option value="FINANCIERO">FINANCIERO</option>
        <option value="GERENCIA">GERENCIA</option>
        <option value="HOGAR OUT">HOGAR OUT</option>
        <option value="IT">IT</option>
        <option value="LEGAL">LEGAL</option>
        <option value="MARKETING">MARKETING</option>
        <option value="MESA DE DESARROLLO">MESA DE DESARROLLO</option>
        <option value="MIGRACION">MIGRACION</option>
        <option value="MOVIL">MOVIL</option>
        <option value="OFF LINE">OFF LINE</option>
        <option value="PORTABILIDAD">PORTABILIDAD</option>
        <option value="PREVENCION FRAUDE">PREVENCION FRAUDE</option>
        <option value="SOPORTE DE OPERACIONES & SSFF">SOPORTE DE OPERACIONES & SSFF</option>
        <option value="TALENTO HUMANO">TALENTO HUMANO</option>
        <option value="TMK">TMK</option>
        <option value="TYT">TYT</option>
        <option value="BLASTER">BLASTER</option>
        <option value="TYT OUT">TYT OUT</option>
        <option value="WORKFORCE">WORKFORCE</option>
        <option value="DATA SCIENCE">DATA SCIENCE</option>
        <option value="PROGRAMACION">PROGRAMACION</option>
    </datalist>

    <input name="cargo" id="cargos" class="input" list="cargo" placeholder="Cargo" required>
    <datalist id="cargo">
        <option value="">Cargo</option>
        <option value="ANALISTA DE CALIDAD">ANALISTA DE CALIDAD</option>
        <option value="ANALISTA DE NOMINA Y CONTRATACION">ANALISTA DE NOMINA Y CONTRATACION</option>
        <option value="ANALISTA DE LEGALIZACION">ANALISTA DE LEGALIZACION</option>
        <option value="ANALISTA DE SELECCION">ANALISTA DE SELECCION</option>
        <option value="AUXILIAR DE SELECCION">AUXILIAR DE SELECCION</option>
        <option value="ANALISTA DE SOPORTE DE OPERACIONES">ANALISTA DE SOPORTE DE OPERACIONES</option>
        <option value="ANALISTA DE TALENTO HUMANO">ANALISTA DE TALENTO HUMANO</option>
        <option value="ANALISTA GESTION DE INVENTARIOS Y AUDITORIA">ANALISTA GESTION DE INVENTARIOS Y AUDITORIA</option>
        <option value="ANALISTA IT">ANALISTA IT</option>
        <option value="ANALISTA SENIOR DE USUARIOS">ANALISTA SENIOR DE USUARIOS</option>
        <option value="ASISTENTE ADMINISTRATIVO">ASISTENTE ADMINISTRATIVO</option>
        <option value="ANALISTA PREVENCION FRAUDE">ANALISTA PREVENCION FRAUDE</option>
        <option value="ANALISTA DE MARKETING">ANALISTA DE MARKETING</option>
        <option value="APRENDIZ- ETAPA LECTIVA">APRENDIZ- ETAPA LECTIVA</option>
        <option value="APRENDIZ- ETAPA PRODUCTIVA">APRENDIZ- ETAPA PRODUCTIVA</option>
        <option value="AUXILIAR DE SERVICIOS GENERALES">AUXILIAR DE SERVICIOS GENERALES</option>
        <option value="BACK OFFICE">BACK OFFICE</option>
        <option value="CIENTIFICO DE DATOS">CIENTIFICO DE DATOS</option>
        <option value="CONTROLLER">CONTROLLER</option>
        <option value="COORDINADOR AREA LEGAL">COORDINADOR AREA LEGAL</option>
        <option value="COORDINADOR DE SELECCION">COORDINADOR DE SELECCION</option>
        <option value="COORDINADOR BACK OFFICE">COORDINADOR BACK OFFICE</option>
        <option value="COORDINADOR CONTACT CENTER">COORDINADOR CONTACT CENTER</option>
        <option value="COORDINADOR DE FORMACION Y CALIDAD">COORDINADOR DE FORMACION Y CALIDAD</option>
        <option value="COORDINADOR IT">COORDINADOR IT</option>
        <option value="COORDINADOR WORKFORCE">COORDINADOR WORKFORCE</option>
        <option value="COORDINADOR FINANCIERO">COORDINADOR FINANCIERO</option>
        <option value="COORDINADOR DE NOMINA Y CONTRATACION">COORDINADOR DE NOMINA Y CONTRATACION</option>
        <option value="COORDINADOR DE SOPORTE DE OPERACIONES">COORDINADOR DE SOPORTE DE OPERACIONES</option>
        <option value="DATAMARSHALL">DATAMARSHALL</option>
        <option value="DESARROLLADOR WEB">DESARROLLADOR WEB</option>
        <option value="EJECUTIVO COMERCIAL">EJECUTIVO COMERCIAL</option>
        <option value="EJECUTIVO COMERCIAL MASTER">EJECUTIVO COMERCIAL MASTER</option>
        <option value="EJECUTIVO DE CUENTA">EJECUTIVO DE CUENTA</option>
        <option value="ENCARGO ANALISTA SENIOR DE USUARIOS">ENCARGO ANALISTA SENIOR DE USUARIOS</option>
        <option value="ENCARGO COORDINADOR SP">ENCARGO COORDINADOR SP</option>
        <option value="ENCARGO COORDINADOR BACK OFFICE">ENCARGO COORDINADOR BACK OFFICE</option>
        <option value="ENCARGO COORDINADOR IT">ENCARGO COORDINADOR IT</option>
        <option value="ENCARGO ANALISTA PREVENCION FRAUDE">ENCARGO ANALISTA PREVENCION FRAUDE</option>
        <option value="ENCARGO ANALISTA DE CALIDAD">ENCARGO ANALISTA DE CALIDAD</option>
        <option value="ENCARGO BACK OFFICE">ENCARGO BACK OFFICE</option>
        <option value="ENCARGO DATAMARSHALL">ENCARGO DATAMARSHALL</option>
        <option value="ENCARGO COORDINADOR WORKFORCE">ENCARGO COORDINADOR WORKFORCE</option>
        <option value="ENCARGO FORMADOR">ENCARGO FORMADOR</option>
        <option value="ENCARGO SUPERVISOR">ENCARGO SUPERVISOR</option>
        <option value="ENCARGO JEFE DE TALENTO HUMANO">ENCARGO JEFE DE TALENTO HUMANO</option>
        <option value="ENCARGO TEAM LEADER">ENCARGO TEAM LEADER</option>
        <option value="ENCARGO ANALISTA DE LEGALIZACION">ENCARGO ANALISTA DE LEGALIZACION</option>
        <option value="ENCARGO COORDINADOR FORMACION Y CALIDAD">ENCARGO COORDINADOR FORMACION Y CALIDAD</option>
        <option value="FORMADOR">FORMADOR</option>
        <option value="GERENTE DE OPERACIONES">GERENTE DE OPERACIONES</option>
        <option value="JEFE DE OPERACIONES">JEFE DE OPERACIONES</option>
        <option value="JEFE DE WORKFORCE">JEFE DE WORKFORCE</option>
        <option value="JEFE FINANCIERA">JEFE FINANCIERA</option>
        <option value="SUPERVISOR CONTACT CENTER">SUPERVISOR CONTACT CENTER</option>
        <option value="SUPERVISOR BACK OFFICE">SUPERVISOR BACK OFFICE</option>
        <option value="SUPERVISOR DE SOPORTE DE OPERACIONES">SUPERVISOR DE SOPORTE DE OPERACIONES</option>
        <option value="PROGRAMADOR">PROGRAMADOR</option>
        <option value="SUPERVISOR DE SST Y MANTENIMIENTO LOCATIVO">SUPERVISOR DE SST Y MANTENIMIENTO LOCATIVO</option>
        <option value="SUPERVISOR DE CONTRATACION Y NOMINA">SUPERVISOR DE CONTRATACION Y NOMINA</option>
        <option value="SUPERVISOR SERVICIOS GENERALES">SUPERVISOR SERVICIOS GENERALES</option>
        <option value="TEAM LEADER">TEAM LEADER</option>
        <option value="AUXILIAR TALENTO HUMANO">AUXILIAR TALENTO HUMANO</option>
    </datalist>

    <input type="text" class="input" placeholder="EPS" id="eps" name="eps" required>

    <select class="input" name="ciudad" id="ciudad" required>
        <option value="">Ciudad</option>
        <option value="BOGOTA">BOGOTA</option>
        <option value="MEDELLIN">MEDELLIN</option>
        <option value="URABA">URABA</option>
    </select>
    
    <select class="input" name="perfil" id="perfil" required>
        <option value="">Perfil</option>
        <option value="EMPLEADO">Empleado</option>
        <option value="SUPERVISOR">Supervisor</option>
        <option value="SUPER TH">Super TH</option>
        <option value="SUPER WF">Super WF</option>
    </select>

    <button class="button"><p class="submit">Subir</p></button>
</form>

<script src="../js/script.js"></script>