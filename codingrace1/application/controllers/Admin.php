<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class Admin extends MY_Controller
    {
        public function HomeAdmin()
        {
            $data['nome'] = $this->session->userdata('nome');
            $data['title'] = "Projeto TFG - Home";
            $this->load->view('commons/header',$data);
            $this->load->view('homeadmin_view');
            $this->load->view('commons/footer');
        }

        /** Funções CRUD Usuários */

        public function Usuario()
        {
            /** Carrega funções de busca do BD */
            $this->load->model('usuarios_model');

            /** Variável com dados para serem passadas para a view */
            $data['nome'] = $this->session->userdata('nome');
            $data['title'] = "Projeto TFG - Usuários";

            // Retorna todos os usuários do BD
            $data['usuarios'] = $this->usuarios_model->GetAll('Nome');

                /** Carrega a view */
            $this->load->view('commons/header',$data);
            $this->load->view('usuario/usuarios_view');
            $this->load->view('commons/footer');
        }

        public function CadUsuario()
        {
            $this->load->model('usuarios_model');
            $validacao = self::Validar('novo_usuario');

            if ($validacao){
                $nome = $this->input->post('nome');
                $senha = $this->input->post('senha');
                $email = $this->input->post('email');
                $ra = $this->input->post('ra');
                $dados_usuario = array(
                    'Nome' => $nome,
                    'Email' => $email,
                    'Senha' => $senha,
                    'RA' => $ra,
                    'Status' => 0,
                    'Tipo_Usuario' => 0
                );
                $status = $this->usuarios_model->Inserir($dados_usuario);
                if(!$status)
                {
                    $this->session->set_flashdata('error', 'Não foi possível inserir o usuário!');
                    $data['nome'] = $this->session->userdata('nome');
                    $data['title'] = "Projeto TFG - Novo Usuário";

                    /** Carrega a view */
                    $this->load->view('commons/header',$data);
                    $this->load->view('usuario/novousuario_view');
                    $this->load->view('commons/footer');
                }else{
                    $this->session->set_flashdata('success', 'Usuário inserido com sucesso!');
                    redirect('usuarios');
                }
            }
            $data['nome'] = $this->session->userdata('nome');
            $data['title'] = "Projeto TFG - Novo Usuário";

            /** Carrega a view */
            $this->load->view('commons/header',$data);
            $this->load->view('usuario/novousuario_view');
            $this->load->view('commons/footer');
        }

        public function AtualizaUsuario()
        {
            $this->load->model('usuarios_model');
            $validacao = self::Validar('editar_usuario');
            $ra = $this->input->post('ra');

            if($validacao) {
                $nome = $this->input->post('nome');
                $email = $this->input->post('email');

                $dados_usuario = array(
                    'Nome' => $nome,
                    'Email' => $email,
                );

                $status = $this->usuarios_model->AtualizaUsuario($ra, $dados_usuario);

                if (!$status) {
                    $this->session->set_flashdata('error', 'Não foi possível atualizar o usuário.');
                    self::EditaUsuario($ra);
                } else {
                    $this->session->set_flashdata('success', 'Usuário atualizado com sucesso.');
                    redirect('usuarios');
                }
            }else{
                self::EditaUsuario($ra);
            }

        }

        public function EditaUsuario($ra)
        {

            $this->load->model('usuarios_model');

            if(is_null($ra))
                redirect('usuarios');

            $data['usuario'] = $this->usuarios_model->GetByRA($ra);

            $data['nome'] = $this->session->userdata('nome');
            $data['title'] = "Projeto TFG - Edita Usuário";

            /** Carrega a view */
            $this->load->view('commons/header',$data);
            $this->load->view('usuario/editarusuario_view');
            $this->load->view('commons/footer');

        }

        public function ExcluiUsuario($ra)
        {
            $this->load->model('usuarios_model');

            if(is_null($ra)) {
                $this->session->set_flashdata('error', 'Não foi possível excluir o usuário.');
                redirect('usuarios');
            }else{
                $data['usuario'] = $this->usuarios_model->ExcluirUsuario($ra);
                $this->session->set_flashdata('success', 'Usuário excluído com sucesso.');
                redirect('usuarios');
            }
        }

        /** Funções CRUD para Cursos */

        public function Cursos(){
            /** Carrega funções de busca do BD */
            $this->load->model('cursos_model');

            /** Variável com dados para serem passadas para a view */
            $data['nome'] = $this->session->userdata('nome');
            $data['title'] = "Projeto TFG - Cursos";

            // Retorna todos os cursos do BD
            $data['cursos'] = $this->cursos_model->GetAll('PIN');

            /** Carrega a view */
            $this->load->view('commons/header',$data);
            $this->load->view('curso/cursos_view');
            $this->load->view('commons/footer');
        }

        public function CadCurso(){

            $this->load->model('cursos_model');
            $validacao = self::Validar('novo_curso');

            if ($validacao){
                $nome = $this->input->post('nome');
                $pin = $this->input->post('pin');
                $ano = $this->input->post('ano');
                $periodo = $this->input->post('periodo');
                $dados_curso = array(
                    'Nome' => $nome,
                    'PIN' => $pin,
                    'Ano' => $ano,
                    'Periodo' => $periodo,
                );
                $status = $this->cursos_model->Inserir($dados_curso);
                if(!$status)
                {
                    $this->session->set_flashdata('error', 'Não foi possível cadastrar o curso!');
                    $data['nome'] = $this->session->userdata('nome');
                    $data['title'] = "Projeto TFG - Novo Curso";

                    /** Carrega a view */
                    $this->load->view('commons/header',$data);
                    $this->load->view('curso/novocurso_view');
                    $this->load->view('commons/footer');
                }else{
                    $this->session->set_flashdata('success', 'Curso cadastrado com sucesso!');
                    redirect('cursos');
                }
            }
            $data['nome'] = $this->session->userdata('nome');
            $data['title'] = "Projeto TFG - Novo Curso";

            /** Carrega a view */
            $this->load->view('commons/header',$data);
            $this->load->view('curso/novocurso_view');
            $this->load->view('commons/footer');
        }

        public function ExcluiCurso($pin){
            $this->load->model('cursos_model');

            if(is_null($pin)) {
                $this->session->set_flashdata('error', 'Não foi possível excluir o curso.');
                redirect('cursos');
            }else{
                $data['usuario'] = $this->cursos_model->ExcluirCurso($pin);
                $this->session->set_flashdata('success', 'Curso excluído com sucesso.');
                redirect('cursos');
            }
        }

        public function AtualizaCurso(){
            $this->load->model('cursos_model');
            $validacao = self::Validar('editar_curso');
            $pin = $this->input->post('pin');

            if($validacao) {
                $nome = $this->input->post('nome');
                $ano = $this->input->post('ano');
                $periodo = $this->input->post('periodo');

                $dados_curso = array(
                    'Nome' => $nome,
                    'Ano' => $ano,
                    'Periodo'=> $periodo,
                );

                $status = $this->cursos_model->AtualizaCurso($pin, $dados_curso);

                if (!$status) {
                    $this->session->set_flashdata('error', 'Não foi possível atualizar o curso.');
                    self::EditaCurso($pin);
                } else {
                    $this->session->set_flashdata('success', 'Curso atualizado com sucesso.');
                    redirect('cursos');
                }
            }else{
                self::EditaCurso($pin);
            }
        }

        public function EditaCurso($pin){
            $this->load->model('cursos_model');

            if(is_null($pin))
                redirect('cursos');

            $data['curso'] = $this->cursos_model->GetByPIN($pin);

            $data['nome'] = $this->session->userdata('nome');
            $data['title'] = "Projeto TFG - Edita Curso";

            /** Carrega a view */
            $this->load->view('commons/header',$data);
            $this->load->view('curso/editarcurso_view');
            $this->load->view('commons/footer');
        }

        public function Validar($operacao)
        {
            if($operacao == 'novo_usuario') {
                $this->form_validation->set_rules('ra', 'RA', 'required|is_unique[Usuario.RA]');
                $this->form_validation->set_rules('nome', 'Nome', 'required');
                $this->form_validation->set_rules('senha', 'Senha', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required');
                $this->form_validation->set_rules('confirmar_email', 'Confirmar Email', 'required|matches[email]');
                $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            }elseif ($operacao == 'editar_usuario'){
                $this->form_validation->set_rules('ra', 'RA', 'required');
                $this->form_validation->set_rules('nome', 'Nome', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required');
                $this->form_validation->set_rules('confirmar_email', 'Confirmar Email', 'required|matches[email]');
                $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            }elseif ($operacao == 'novo_curso'){
                $this->form_validation->set_rules('pin', 'PIN', 'required|is_unique[Curso.PIN]');
                $this->form_validation->set_rules('nome', 'Nome', 'required');
                $this->form_validation->set_rules('ano', 'Ano', 'required');
                $this->form_validation->set_rules('periodo', 'Periodo', 'required');
                $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            }elseif ($operacao == 'editar_curso'){
                $this->form_validation->set_rules('pin', 'PIN', 'required');
                $this->form_validation->set_rules('nome', 'Nome', 'required');
                $this->form_validation->set_rules('ano', 'Ano', 'required');
                $this->form_validation->set_rules('periodo', 'Periodo', 'required');
                $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            }

            return $this->form_validation->run();
        }

        public function teste($ra){

            $data['ra'] = $ra;
            $this->load->view('teste_view',$data);
        }

    }

?>