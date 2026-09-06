import React from "react"

import { createRoot } from 'react-dom/client';

import { QueryClient, QueryClientProvider } from "react-query";

const queryClient = new QueryClient();

async function mountStandaloneAbsenceWidgets() {
    const widgets = Array.from(document.querySelectorAll('.wp4t-react-absence'));

    if (!widgets.length) {
        return;
    }

    const { Absence } = await import('./Absence.js');

    widgets.forEach((widget) => {
        if (widget.dataset.wp4tMounted === '1') {
            return;
        }

        const postId = parseInt(widget.getAttribute('data-post-id') || '0', 10);
        const userId = parseInt(widget.getAttribute('data-user-id') || '0', 10);
        const mode = widget.getAttribute('data-mode') || 'signup';

        const root = createRoot(widget);
        root.render(
            <React.StrictMode>
                <QueryClientProvider client={queryClient}>
                    <Absence
                        makeNotification={(message) => { console.log('Absence update', message); }}
                        current_user_id={userId}
                        post_id={postId}
                        mode={mode}
                    />
                </QueryClientProvider>
            </React.StrictMode>
        );

        widget.dataset.wp4tMounted = '1';
    });
}

window.addEventListener('load', async function(event) {

    await mountStandaloneAbsenceWidgets();

    try {

    const currentdoc = document.getElementById('react-agenda');
    if(!currentdoc) {
        return;
    }
    console.log('currentdoc',currentdoc);

    let mode_init = currentdoc.getAttribute('mode');

    const evaluation = {'ID':'','name':'','project':'','manual':'','title':''};
    const post_id = currentdoc.getAttribute('post_id');

    const evalme = currentdoc.getAttribute('evalme');
    console.log('mode_init',mode_init);

    if('meeting_vote' == mode_init) {
        console.log('load voting tool');
        const rsvpsection = document.getElementById('rsvpsection');
        if(rsvpsection) {
            rsvpsection.remove();
        }
        const { default: Voting } = await import('./Voting.js');
        const root = createRoot(currentdoc); // createRoot(container!) if you use TypeScript
        root.render(<React.StrictMode>
        <QueryClientProvider client={queryClient}>
            <Voting post_id={post_id} />
        </QueryClientProvider>
      </React.StrictMode>);
        return;
    }
    console.log('after voting tool');

    if(evalme)

    {

        evaluation.ID = evalme;

        evaluation.name = currentdoc.getAttribute('name');

        evaluation.project = currentdoc.getAttribute('project');

        evaluation.manual = currentdoc.getAttribute('manual');

        evaluation.title = currentdoc.getAttribute('title');

        console.log('evaluation',evaluation);

    }

    if(('evaluation_demo' == mode_init) || ('evaluation_admin' == mode_init) || ('evaluation_guest' == mode_init))

    {
        const { EvalWrapper } = await import('./EvalWrapper.js');
        const root = createRoot(document.getElementById('react-agenda'));

        root.render(

            <React.StrictMode>

                <QueryClientProvider client={queryClient}>

                    <EvalWrapper mode_init={mode_init} evaluation={evaluation} post_id={post_id} />

                </QueryClientProvider>

          </React.StrictMode>);        

    }

    else if('settings_admin' == mode_init)

    {
        const { default: ReorgWrapper } = await import('./ReorgWrapper.js');
        const root = createRoot(document.getElementById('react-agenda'));

        root.render(

            <React.StrictMode>

                <QueryClientProvider client={queryClient}>

                    <ReorgWrapper  post_id={post_id} />

                </QueryClientProvider>

          </React.StrictMode>);        

    }

    else {
        const { default: Agenda } = await import('./Agenda.js');
        const root = createRoot(document.getElementById('react-agenda'));

        root.render(

            <React.StrictMode>

                <QueryClientProvider client={queryClient}>

                    <Agenda mode_init={mode_init} evaluation={evaluation} post_id={post_id} />

                </QueryClientProvider>

          </React.StrictMode>);        

    }

}

catch(error) {

    console.log('no current doc found',error);

}



});



//<ReactQueryDevtools initialIsOpen={false} position="bottom-right" />

