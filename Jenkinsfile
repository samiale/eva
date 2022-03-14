pipeline {
  agent any
  stages {
    stage('SCM') {
      steps {
        build(job: 'build', propagate: true, quietPeriod: 4, wait: true)
        readTrusted 'C:\\Users\\slettat\\Desktop\\CI'
      }
    }

  }
}