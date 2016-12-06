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
            $this->load->model('usuarios_model');
            //$validacao = self::Validar();

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
                }else{
                    $this->session->set_flashdata('success', 'Usuário inserido com sucesso!');
                    redirect('usuarios');
                }

            $this->load->view('usuarios_view');
        }

        public function AtualizaUsuario()
        {


                $nome = $this->input->post('nome');
                $email = $this->input->post('email');
                $dados_usuario = array(
                    'Nome' => $nome,
                    'Email' => $email,
                );

                $status = $this->usuarios_model->Atualizar($dados_usuario['RA'],$dados_usuario);

                if(!$status){
                    $dados['usuario'] = $this->contatos_model->GetById($dados_usuario['RA']);
                    $this->session->set_flashdata('error', 'Não foi possível atualizar o usuário.');
                }else{
                    $this->session->set_flashdata('success', 'Usuário atualizado com sucesso.');

                    redirect('usuarios');
                }

            redirect('usuarios');
        }

        public function EditaUsuario()
        {

            $id = $this->uri->segment(2);

            if(is_null($id))
                redirect('ususarios');

            $dados['contato'] = $this->contatos_model->GetById($id);

            $this->load->view('editar',$dados);
        }

        public function Validar()
        {
            $this->form_validation->set_rules('ra', 'RA', 'required|is_unique[Usuario.RA]');
            $this->form_validation->set_rules('nome', 'Nome', 'required');
            $this->form_validation->set_rules('senha', 'Senha', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('confirmar_email', 'Confirmar Email', 'required|matches[email]');
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');


            return $this->form_validation->run();
        }

    }

?>