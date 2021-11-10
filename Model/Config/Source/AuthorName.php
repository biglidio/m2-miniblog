<?php

namespace Biglidio\MiniBlog\Model\Config\Source;

use Magento\User\Model\ResourceModel\User\CollectionFactory as UserCollectionFactory;

class AuthorName implements \Magento\Framework\Option\ArrayInterface
{
    /** @var UserCollectionFactory */
    protected $userCollectionFactory;

    public function __construct(
        UserCollectionFactory $userCollectionFactory
    )
    {
        $this->userCollectionFactory = $userCollectionFactory;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $adminUsers = $this->userCollectionFactory->create();

        $adminUserNames = [];

        foreach ($adminUsers as $adminUser) {
            $adminUserNames[] = [
                'value' => $adminUser->getUserId(),
                'label' => $adminUser->getFirstname() . ' ' . $adminUser->getLastname()
            ];
        }

        return $adminUserNames;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $adminUsers = $this->userCollectionFactory->create();

        $adminUserNames = [];

        foreach ($adminUsers as $adminUser) {
            $adminUserNames[$adminUser->getUserId()] = $adminUser->getFirstname() . ' ' . $adminUser->getLastname();
        }

        return $adminUserNames;
    }
}
