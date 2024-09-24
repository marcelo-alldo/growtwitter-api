<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_pode_se_registrar_com_dados_validos()
    {
        // Prepara os dados do usuário
        $userData = [
            'name' => 'João',
            'surname' => 'Silva',
            'username' => 'joaosilva',
            'email' => 'joaosilva@exemplo.com',
            'avatar_url' => 'http://exemplo.com/avatar.jpg',
            'password' => 'senha',
            'password_confirmation' => 'senha',
        ];

        // Envia requisição POST para registrar
        $response = $this->postJson('/api/users', $userData);

        //  Verifica resposta ( Deixei json estruturado pois não tem como saber o resultado das strings que vão vir, mas o nome sim.)
        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'msg',
                'user' => [
                    'id',
                    'name',
                    'surname',
                    'username',
                    'email',
                    'avatar_url',
                    'created_at',
                    'updated_at',
                ],
                'token',
            ]);

        //  Usuário está no banco de dados
        $this->assertDatabaseHas('users', [
            'email' => 'joaosilva@exemplo.com',
            'username' => 'joaosilva',
        ]);
    }
    public function test_registro_de_usuario_falha_com_dados_invalidos()
    {
        // Envia requisição POST com campos faltando
        $response = $this->postJson('/api/users', []);

        // Verifica erros de validação
        $response->assertStatus(422)
            ->assertJsonStructure([
                'success',
                'msg',
            ]);
    }
    public function test_usuario_autenticado_pode_ver_suas_informacoes_de_perfil()
    {
        // Cria e autentica um usuário
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        // Envia requisição GET para /users
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/users');

        // Verifica resposta
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'msg' => 'Usuário autenticado',
                'data' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    // Outros campos conforme necessário
                ],
            ]);
    }
    public function test_usuario_nao_autenticado_nao_pode_ver_perfil()
    {
        // Envia requisição GET sem autenticação
        $response = $this->getJson('/api/users');

        // Verifica não autorizado
        $response->assertStatus(401);
    }
    public function test_usuario_autenticado_pode_atualizar_seu_perfil()
    {
        // Cria e autentica um usuário
        $user = User::factory()->create([
            'name' => 'João',
            'surname' => 'Silva',
            'username' => 'joaosilva',
        ]);
        $token = $user->createToken('test-token')->plainTextToken;

        // Prepara dados de atualização
        $updateData = [
            'name' => 'Maria',
            'surname' => 'Santos',
            'username' => 'mariasantos',
        ];

        // Envia requisição PUT para atualizar
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->putJson("/api/users/{$user->id}", $updateData);

        // Verifica resposta
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'msg' => 'Usuário alterado com sucesso',
                'data' => [
                    'id' => $user->id,
                    'name' => 'Maria',
                    'surname' => 'Santos',
                    'username' => 'mariasantos',
                ],
            ]);

        // Verifica se o banco de dados está atualizado
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Maria',
            'surname' => 'Santos',
            'username' => 'mariasantos',
        ]);
    }
    public function test_usuario_autenticado_pode_deletar_sua_conta()
    {
        // Cria e autentica um usuário
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        // Envia requisição DELETE para remover o usuário
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->deleteJson("/api/users/{$user->id}");

        // Verifica resposta
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'msg' => 'Usuário deletado com sucesso',
            ]);

        // Verifica se o Usuário foi deletado do banco de dados
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
    public function test_usuario_nao_autenticado_nao_pode_realizar_operacoes_de_usuario()
    {
        // Cria um usuário
        $user = User::factory()->create();

        // Tenta acessar rotas protegidas sem autenticação
        $response = $this->getJson('/api/users');
        $response->assertStatus(401);

        $response = $this->putJson("/api/users/{$user->id}", [
            'name' => 'Novo Nome',
        ]);
        $response->assertStatus(401);

        $response = $this->deleteJson("/api/users/{$user->id}");
        $response->assertStatus(401);
    }
}
