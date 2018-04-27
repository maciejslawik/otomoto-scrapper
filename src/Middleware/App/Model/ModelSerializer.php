<?php
/**
 * File: ModelSerializer.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\App\Model;

use MSlwk\Otomoto\App\Model\Data\ModelDTO;
use MSlwk\Otomoto\App\Model\Data\ModelDTOArray;

/**
 * Class ModelSerializer
 * @package MSlwk\Otomoto\Middleware\App\Model
 */
class ModelSerializer
{
    /**
     * @param ModelDTOArray $modelDTOArray
     * @return string
     */
    public function serialize(ModelDTOArray $modelDTOArray): string
    {
        $modelArray = [];
        foreach ($modelDTOArray as $modelDTO) {
            $modelArray[] = [
                'name' => $modelDTO->getName()
            ];
        }
        return serialize($modelArray);
    }

    /**
     * @param string $modelsDTOArrayString
     * @return ModelDTOArray
     */
    public function unserialize(string $modelsDTOArrayString): ModelDTOArray
    {
        $modelArray = unserialize($modelsDTOArrayString);
        $modelDTOArray = new ModelDTOArray();

        foreach ($modelArray as $modelData) {
            $modelDTO = new ModelDTO($modelData['name']);
            $modelDTOArray->add($modelDTO);
        }

        return $modelDTOArray;
    }
}
