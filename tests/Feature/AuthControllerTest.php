<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    // Isso limpa o banco antes de executar o teste
    use RefreshDatabase;
    public function test_usuario_pode_logar_com_credenciais_corretas()
    {
        //  Cria um usuário
        $password = 'password';
        $user = User::factory()->create([
            'password' => Hash::make($password),
        ]);

        // Tenta logar
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        //  Verifica resposta
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'msg',
                'data' => [
                    'user',
                    'token',
                ],
            ]);
    }
    public function test_usuario_nao_pode_logar_com_credenciais_incorretas()
    {
        // Cria um usuário
        $user = User::factory()->create([
            'password' => Hash::make('senha-correta'),
        ]);

        // Tenta logar com senha errada
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'senha_errada',
        ]);

        // Verifica resposta
        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'msg' => 'Verificar email ou senha.',
            ]);
    }
    public function test_usuario_nao_pode_logar_com_email_inexistente()
    {
        // Tenta logar com email inexistente
        $response = $this->postJson('/api/login', [
            'email' => 'inexistente@exemplo.com',
            'password' => 'senha',
        ]);

        // Verifica resposta
        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'msg' => 'Verificar email ou senha.',
            ]);
    }
    public function test_login_exige_email_e_senha()
    {
        // Tenta logar sem credenciais
        $response = $this->postJson('/api/login', []);

        // Verifica erros de validação
        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'msg' => 'Erro ao logar',
            ]);
    }
    public function test_usuario_autenticado_pode_fazer_logout()
    {
        // Cria e autentica um usuário
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        // Tenta fazer logout
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->deleteJson('/api/logout');

        // Verifica resposta
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'msg' => 'Logout feito com sucesso',
            ]);

        //  Token é deletado
        $this->assertCount(0, $user->tokens);
    }
    public function test_logout_exige_autenticacao()
    {
        // Tenta fazer logout sem autenticação
        $response = $this->deleteJson('/api/logout');

        // Verifica não autorizado
        $response->assertStatus(401);
    }
}
