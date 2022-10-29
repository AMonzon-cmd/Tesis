## Docker

La distribucion de los contenedores docker se ha implementado usando 4 contenedores y docker-compose , de la siguiente manera:
* Un contenedor para el backend / papi . Todas las rutas fueron agrupadas para estar bajo /api/
* Un contenedor para el frontend / pcliente . Las rutas no han sido modificadas.
* Un contenedor para el backoffice / pbackoffice . La/s rutas han sido modificadas para estar bajo /backoffice/
* Un contenedor para el reverse proxy, o administrador de peticiones http, "nginx". Aqui se puede observar la razón por la cual las rutas de la api y el backoffice fueron agrupadas como se describe anteriormente. Todas las peticiones http pasan primero por el proxy nginx, que dependiendo de como comienza el nombre de la ruta, decide si es una peticion al front, al backend, o al backoffice. Si la ruta inicia con /api/ entonces será para el backend. Si inicia con /backoffice/ entonces será para el backoffice. Si no es ninguno de estos casos, entonces sera para el frontend.

### Deployment

Para hacer el deploy, se ejecuta el siguiente comando en la maquina servidor, que debe contener soporte para docker y docker compose

`$ docker-compose build && docker-compose up -d`

Para generar llamadas a la API desde el Frontend hay que usar la ruta "/api/...etc"