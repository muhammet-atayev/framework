<?php

namespace Shopper\Framework\Http\Livewire\Settings\Attributes;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Shopper\Framework\Models\Shop\Product\Attribute;
use Shopper\Framework\Models\Shop\Product\AttributeValue;
use WireUi\Traits\Actions;

class Values extends Component
{
    use Actions;

    public Attribute $attribute;
    public Collection $values;
    public string $type = 'select';
    protected $listeners = ['updateValues'];

    public function mount(Attribute $attribute)
    {
        $this->attribute = $attribute;
        $this->values = $attribute->values;
        $this->type = $attribute->type;
    }

    public function updateValues()
    {
        $this->values = AttributeValue::query()
            ->where('attribute_id', $this->attribute->id)
            ->get();
    }

    public function removeValue(int $id)
    {
        AttributeValue::query()->find($id)->delete();

        $this->emitSelf('updateValues');

        $this->notification()->success(
            __('shopper::layout.status.delete'),
            __('Your value have been correctly removed!')
        );
    }

    public function render()
    {
        return view('shopper::livewire.settings.attributes.values');
    }
}
