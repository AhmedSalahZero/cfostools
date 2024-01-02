<x-form.modal :title="__('Filter Options')" :table-id="$tableId" :type="'filter'">

@include('admin.revenue-business-line.options' , [
                    'type'=>'filter'
                ] )

               <x-form.filter-btn :type="'filter'" :id="'filter-btn-id'" :datatable-id="$tableId">
               
               </x-form.filter-btn>

               </x-form.modal>