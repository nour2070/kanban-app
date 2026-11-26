import './bootstrap';
import Sortable from 'sortablejs';

document.addEventListener('livewire:initialized', () => {
    const initSortable = () => {
        const columns = ['todo', 'in-progress', 'review', 'done'];
        
        columns.forEach(colId => {
            let el = document.getElementById(colId);
            if (el && !el.classList.contains('sortable-initialized')) {
                el.classList.add('sortable-initialized');
                
                new Sortable(el, {
                    group: 'shared',
                    animation: 150,
                    ghostClass: 'opacity-50',
                    dragClass: 'rotate-2',
                    onEnd: function (evt) {
                        let taskId = evt.item.getAttribute('data-id');
                        let newStatus = evt.to.getAttribute('data-status');
                        
                        Livewire.dispatch('updateTaskStatus', { taskId: taskId, newStatus: newStatus });
                    }
                });
            }
        });
    };

    initSortable();
    
    Livewire.hook('morph.updated', ({ el, component }) => {
        initSortable();
    });
});