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
            $this->load->view('usuarios_view');
            $this->load->view('commons/footer');
        }

        public function CadUsuario()
        {

            $this->form_validation->set_rules('ra', 'RA', 'required|is_unique[Usuario.RA]');
            $this->form_validation->set_rules('nome', 'Nome', 'required');
            $this->form_validation->set_rules('senha', 'Senha', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('confirmar_email', 'Confirmar Email', 'required|matches[email]');
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

            /** Salva dados usuário */
            $this->load->model('usuarios_model');
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

            if ($this->form_validation->run() == FALSE) {
                $data['nome'] = $this->session->userdata('nome');
                $data['title'] = "Projeto TFG - Novo Usuário";
                $this->load->view('commons/header',$data);
                $this->load->view('cadusuario_form_view');
                $this->load->view('commons/footer');
            } else{
                $usuario = $this->usuarios_model->Inserir($dados_usuario);
                if ($usuario){
                    $this->session->set_flashdata('message', "Usuário inserido com sucesso!");
                    redirect('usuarios_view', 'refresh');
                }else{

                }
            }

        }

    }

?>