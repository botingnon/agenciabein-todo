<?php
/**
 * Gerenciamento de tarefas
 *
 * @category Api
 * @package  Todo
 * @author   Valdir Botingnon <valdir.botingnon@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://localhost:3000/doc/#!/task
 */
namespace Todo\Api;

use \Luracast\Restler\RestException;

/**
 * @access protected
 * @class  AccessControl
 */
class Task
{

    /**
     * Lista de tarefas
     *
     * Retorna lista de tarefas pendentes, podendo ser exibidas todas
     *
     * @param bool $show_all {@from query}
     *                    Opcionalmente exibe tarefas concluídas
     *
     * @return array Lista de tarefas
     *
     */
    public function index($show_all = false)
    {
        try {
            $query = $show_all ? '' : 'completed = 0';

            return \R::exportAll(
                \R::findAll('task', $query)
            );
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Cadastra tarefa
     *
     * Cadastra uma nova tarefa
     *
     * @param string $title       {@from body}{@min 1}{@max 255}
     *                            Título da tarefa
     *
     * @return array Tarefa cadastrada
     *
     */
    public function post($title)
    {
        $Task = \R::dispense('task');
        $Task->title = $title;
        $Task->completed = 0;

        $id = \R::store($Task);

        return $Task;
    }

    /**
     * Altera tarefa
     *
     * Indica se a tarefa foi completa
     *
     * @param int $id Identificador da tarefa
     *
     * @return array Tarefa cadastrada
     *
     */
    public function put($id, $request_data = null)
    {
        $Task = \R::load('task', $id);
        if (!$Task->id) {
            throw new RestException(404, '`id` not found.');
        }
        $Task->completed = 1;

        \R::store($Task);

        return $Task;
    }

    /**
     * Apaga uma tarefa
     *
     * Apaga uma tarefa de acordo com o id informado
     *
     * @param int $id Identificador da tarefa
     *
     * @return array
     */
    public function delete($id)
    {
        $Task = \R::load('task', $id);
        \R::trash($Task);

        return [];
    }
}
