<?php 

namespace Biglidio\MiniBlog\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Actions extends Column
{
    /** @var UrlInterface */
    protected $urlBuilder;

    /**
     * Actions constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    )
    {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Undocumented function
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach($dataSource['data']['items'] as & $item) {
            if (!isset($item['id'])) {
                continue;
            }

            $item[$this->getData('name')] = [
                'edit' => [
                    'href' => $this->urlBuilder->getUrl('miniblog/post/edit', [
                        'id' => $item['id']
                    ]),
                    'label' => __('Edit')
                ],
                'delete' => [
                    'href' => $this->urlBuilder->getUrl('miniblog/post/delete', [
                        'id' => $item['id']
                    ]),
                    'label' => __('Delete'),
                    'confirm' => [
                        'title' => __('Delete "%1"', $item['title']),
                        'message' => __('Are you sure you want to delete the "%1" record?', $item['title']),
                    ],
                ]
            ];
        }

        return $dataSource;
    }
}