<?php
/**
 * Copyright © @author    Tigren Solutions <info@tigren.com> @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved. @license   Open Software License ("OSL") v. 3.0 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Tigren\SimpleBlog\Model\Tigrenblogpost;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Tigren\SimpleBlog\Model\ResourceModel\TigrenBlogPost\CollectionFactory;

class DataProvider extends AbstractDataProvider
{

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;
    /**
     * @inheritDoc
     */
    protected $collection;


    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $data = $model->getData();
            //            dd($data);
            unset($data['post_image']);
            $data['post_image'][0] = [
                'name' => 'test.png',
                'url' => '#'
            ];
            //            dd($data);
            $this->loadedData[$model->getId()] = $data;
        }

        return $this->loadedData;
    }
}

