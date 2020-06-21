<style scoped>
  .nav-badge {
    min-width: 200px;
    padding: 20px 10px;
    background: #25243D;
    color: white;
  }
</style>

<template>
  <div class="uk-container uk-width-1-1 uk-padding-remove">
    <div class="uk-flex uk-flex-between uk-flex-middle uk-background-muted">
      <div class="nav-badge uk-text-center">
        <span uk-icon="icon: user"></span>
        <span class="uk-text-uppercase">Clients</span>
      </div>
      <a href="#modal-center" class="uk-button uk-button-primary uk-text-capitalize" uk-toggle>
        add new client <span uk-icon="icon: plus-circle"></span>
      </a>
    </div>

    <div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l uk-padding-small" uk-grid="masonry: true">
      <div v-for="client in clients">
        <Client
          :client="client"
          @edit-client="onEditClient"
          @create-project="onAddProject"
          @update-project="onUpdateProject"
          @delete-project="onDeleteProject"
        />
      </div>
    </div>

    <div id="modal-center" class="uk-flex-top" uk-modal="bg-close: false">
      <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
          <h2 class="uk-modal-title">{{ modalTitle }}</h2>
        </div>
        <div class="uk-modal-body">
          <ValidationObserver ref="form" tag="form" class="uk-form-stacked">
            <ValidationProvider :rules="client.rules.name" tag="div" name="name" class="uk-margin" v-slot="{ errors, classes }">
              <label class="uk-form-label" for="name">Name</label>
              <div class="uk-form-controls">
                <input
                  v-model="client.name"
                  :class="classes"
                  placeholder="Client name..."
                  class="uk-input"
                  name="name"
                  type="text"
                  ref="input"
                  id="name"
                >
                <span class="uk-form-controls-text uk-text-danger">{{ errors[0] }}</span>
              </div>
            </ValidationProvider>

            <div class="uk-text-right">
              <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
              <button class="uk-button uk-button-primary" type="button" @click="modalHandler">Save</button>
            </div>
          </ValidationObserver>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import UIkit from "uikit";
  import Client from "./Client";
  import { cloneDeep } from "lodash";
  import { Client as ClientApi } from "../apis/Client";
  import { ValidationObserver, ValidationProvider } from "vee-validate";

  export default {
    name: "Clients",
    props: {
      items: {
        required: true,
        type: Array
      }
    },
    components: {
      Client,
      ValidationObserver,
      ValidationProvider
    },
    computed: {
      modalTitle() {
        return this.mode === ClientApi.MODE_CREATE ? 'Create New Client' : 'Update Client';
      },
      modalHandler() {
        switch (this.mode) {
          case ClientApi.MODE_CREATE:
            return this.createClient;
          case ClientApi.MODE_UPDATE:
            return this.updateClient;
          default:
            return null;
        }
      }
    },
    data: () => ({
      mode: ClientApi.MODE_CREATE,
      modal: undefined,
      client: new ClientApi(),
      clients: []
    }),
    methods: {
      createClient() {
        this.$refs.form.validate().then(valid => {
          if (!valid) return;

          this.client.create()
            .then(response => {
              this.clients.push(response.data.client);
              this.client.set(ClientApi.state);
              this.modal.hide();
            })
            .catch(error => {
              if (error.response.status === 422) {
                this.$refs.form.setErrors(error.response.data.errors);
              }

              console.log(error.response.data.message);
            });
        });
      },
      updateClient() {
        this.$refs.form.validate().then(valid => {
          if (!valid) return;

          this.client.update()
            .then(response => {
              const c = this.clients.find(c => c.id === this.client.id);

              this.clients.splice(c, 1, response.data.client);
              this.client.set(ClientApi.state);
              this.modal.hide();
            })
            .catch(error => {
              if (error.response.status === 422) {
                this.$refs.form.setErrors(error.response.data.errors);
              }

              console.log(error.response.data.message);
            });
        });
      },
      onEditClient(client) {
        this.client.set(client);
        this.mode = ClientApi.MODE_UPDATE;
        this.modal.show();
        this.$refs.input.focus();
      },
      onAddProject({clientId, project}) {
        const c = this.clients.findIndex(c => c.id === clientId);
        console.log(c);

        this.clients[c].projects.push(project);
      },
      onUpdateProject({clientId, project}) {
        const c = this.clients.findIndex(c => c.id === clientId);
        const p = this.clients[c].projects.findIndex(p => p.id === project.id);

        this.clients[c].projects.splice(p, 1, project);
      },
      onDeleteProject({clientId, p}) {
        const c = this.clients.findIndex(c => c.id === clientId);

        this.clients[c].projects.splice(p, 1);
      }
    },
    created() {
      this.clients = this.items.map(item => cloneDeep(item));
    },
    mounted() {
      this.modal = UIkit.modal('#modal-center');

      UIkit.util.on('#modal-center', 'hide', () => {
        this.client.set(Client.state);
        this.mode = ClientApi.MODE_CREATE;
      });
    }
  }
</script>
