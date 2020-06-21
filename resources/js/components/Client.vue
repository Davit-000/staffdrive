<template>
  <div class="uk-card uk-card-default">
    <div class="uk-card-header">
      <div class="uk-grid-small uk-flex-middle uk-flex-between" uk-grid>
        <div class="uk-width-expand" @click="$emit('edit-client', client)">
          <p class="uk-text-meta uk-margin-remove-bottom">Client</p>
          <h3 class="uk-card-title uk-margin-remove-top">{{ client.name }}</h3>
        </div>
        <div class="uk-width-expand uk-text-right">
          <button @click="toggleForm(true)" type="button" class="uk-icon-link uk-text-success" uk-icon="plus-circle"></button>
        </div>
      </div>
    </div>
    <div class="uk-card-body">
      <div class="uk-flex uk-flex-column">
        <div v-for="(project, p) in client.projects" class="uk-width-expand">
          <div class="uk-card uk-card-default uk-margin-small-bottom" style="box-shadow: none; border: 1px solid #EEEEEE">
              <div class="uk-flex uk-flex-between uk-flex-middle" style="padding: 10px">
                <div>{{ project.name }}</div>
                <div>
                  <button @click="editProject(project)" type="button" class="uk-icon-link" uk-icon="pencil"></button>
                  <button @click="destroyProject(project, p)" type="button" class="uk-icon-link uk-text-danger" uk-icon="close"></button>
                </div>
              </div>
          </div>
        </div>
      </div>

      <ValidationObserver v-show="showForm" ref="form" tag="form" class="uk-form-stacked">
        <ValidationProvider :rules="project.rules.name" tag="div" name="name" class="uk-margin" v-slot="{ errors, classes }">
          <div class="uk-form-controls">
            <div class="uk-inline uk-width">
              <input
                v-model="project.name"
                @keypress.enter.prevent="handler"
                :class="classes"
                placeholder="Project name..."
                class="uk-input"
                title="name"
                ref="input"
                type="text"
              >
              <button @click="toggleForm(false)" type="button" class="uk-form-icon uk-form-icon-flip" uk-icon="icon: close"></button>
            </div>

            <div class="uk-form-controls-text uk-text-danger">{{ errors[0] }}</div>
          </div>
        </ValidationProvider>
      </ValidationObserver>
    </div>
  </div>
</template>

<script>
  import { Project } from "../apis/Project";
  import { ValidationObserver, ValidationProvider } from "vee-validate";

  export default {
    props: {
      client: {
        required: true,
        type: Object,
      }
    },
    components: {
      ValidationObserver,
      ValidationProvider
    },
    computed: {
      handler() {
        switch (this.mode) {
          case Project.MODE_CREATE:
            return this.createProject;
          case Project.MODE_UPDATE:
            return this.updateProject;
          default:
            return null;
        }
      }
    },
    data: () => ({
      mode: Project.MODE_CREATE,
      showForm: false,
      project: new Project(),
    }),
    methods: {
      toggleForm(show) {
        this.showForm = show;
        this.project.set(Project.state);
      },
      createProject() {
        this.$refs.form.validate().then(valid => {
          if (!valid) return;

          this.project.create()
            .then(response => {
              this.$refs.input.blur();

              this.$emit('create-project', {
                clientId: this.client.id,
                project: response.data.project
              });

              this.toggleForm(false);
            })
            .catch(error => {
              if (error.response.status === 422) {
                this.$refs.form.setErrors(error.response.data.errors);
              }

              console.log(error.response.data.message);
            });
        });
      },
      editProject(project) {
        this.mode = Project.MODE_UPDATE;
        this.project.set(project);
        this.showForm = true;
        this.$refs.input.focus();
      },
      updateProject() {
        this.$refs.form.validate().then(valid => {
          if (!valid) return;

          this.project.update()
            .then(response => {
              this.$emit('update-project', {
                clientId: this.client.id,
                project: response.data.project
              });

              this.toggleForm(false);
              this.mode = Project.MODE_CREATE;
            })
            .catch(error => {
              console.log(error);
              if (error.response.status === 422) {
                this.$refs.form.setErrors(error.response.data.errors);
              }

              console.log(error.response.data.message);
            });
        });
      },
      destroyProject(project, p) {
        this.project.set(project);

        this.project.destroy()
          .then(() => this.$emit('delete-project', {
            clientId: this.client.id,
            p,
          }))
          .catch(error => console.log(error));
      }
    },
    created() {
      this.project.prefix = `clients/${this.client.id}`;
    }
  }
</script>
