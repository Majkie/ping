<script setup lang="ts">
import { reactive, ref } from 'vue'

import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'
import { Alert, AlertDescription } from '@/components/ui/alert'

interface ValidationErrors {
  errors: {
    uuid?: string[]
    battery_percent?: string[]
  }
}

const form = reactive<{
  uuid: string
  battery_percent: number
}>({
  uuid: '',
  battery_percent: 0,
})

const errors = reactive<{
  uuid?: string
  battery_percent?: string
}>({})
const isSubmitting = ref(false)
const isSuccess = ref(false)

async function onSubmit() {
  isSubmitting.value = true
  isSuccess.value = false
  errors.uuid = ''
  errors.battery_percent = ''

  try {
    const response = await fetch('/api/ping', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify({
        uuid: form.uuid,
        battery_percent: Number(form.battery_percent),
      }),
    })

    if (response.status === 422) {
      const data: ValidationErrors = await response.json()
      if (data.errors?.uuid) errors.uuid = data.errors.uuid[0]
      if (data.errors?.battery_percent) errors.battery_percent = data.errors.battery_percent[0]
      return
    }

    if (response.ok) {
      isSuccess.value = true
      form.uuid = ''
      form.battery_percent = 0
    }
  } finally {
    isSubmitting.value = false
  }
}
</script>

<template>
  <div class="flex min-h-screen items-center justify-center">
    <form @submit.prevent="onSubmit" class="w-full max-w-sm space-y-4">
      <Alert v-if="isSuccess" variant="default">
        <AlertDescription>Ping submitted successfully.</AlertDescription>
      </Alert>

      <div class="space-y-2">
        <Label for="uuid">UUID</Label>
        <Input id="uuid" v-model="form.uuid" type="text" placeholder="Enter UUID" />
        <p v-if="errors.uuid" class="text-sm text-destructive">{{ errors.uuid }}</p>
      </div>

      <div class="space-y-2">
        <Label for="battery_percent">Battery Percent</Label>
        <Input id="battery_percent" v-model="form.battery_percent" type="number" inputmode="numeric" min="0" max="100" placeholder="0-100" />
        <p v-if="errors.battery_percent" class="text-sm text-destructive">{{ errors.battery_percent }}</p>
      </div>

      <Button type="submit" :disabled="isSubmitting" class="w-full">
        Submit
      </Button>
    </form>
  </div>
</template>