web_app "testsite" do
  server_name "testsite.dev"
  server_aliases ["my-site.testsite.dev"]
  docroot "/vagrant/web"
  application_name "testsite_log"
  allow_override "all"
  enabled "true"
end