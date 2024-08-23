<a name="login"></a>

# Login

### Endpoint (Login)

Cria uma sessão e obtém token de acesso.

>

| Method |     URL      | Headers |
| :----: | :----------: | :-----: |
|  POST  | `/api/login` |    -    |

#### Body rules

```json
{
    "email": "string",
    "password": "string"
}
```

### Responses

> {success.fa-check-circle-o} Sucesso

Código `200`

```json
{
    "success": "boolean",
    "msg": "string",
    "data": {
        "user": "string",
        "token": "string"
    }
}
```

> {danger.fa-check-circle-o} Verificar e-mail ou senha

Código `401`

```json
{
    "success": "boolean",
    "msg": "string"
}
```

---

> {danger.fa-check-circle-o} Erro ao logar

Código `400`

```json
{
    "success": "boolean",
    "msg": "string"
}
```

---

<br />

<a name="logout"></a>

# Logout

### Endpoint (Logout)

Deleta uma sessão criada anteriormente.

>

| Method |      URL      | Headers |
| :----: | :-----------: | :-----: |
| DELETE | `/api/logout` |  AUTH   |

### Responses

> {success.fa-check-circle-o} Sucesso

Código `200`

```json
{
    "success": "boolean",
    "msg": "string"
}
```

> {danger.fa-check-circle-o} Erro ao deslogar

Código `400`

```json
{
    "success": "boolean",
    "msg": "string"
}
```
